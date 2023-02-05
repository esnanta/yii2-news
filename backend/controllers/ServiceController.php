<?php

namespace backend\controllers;

use Yii;
use backend\models\Service;
use backend\models\ServiceSearch;
use backend\models\Customer;
use backend\models\Enrolment;
use backend\models\Staff;
use backend\models\OutletDetail;
use backend\models\ServiceDetail;
use backend\models\Office;
use backend\models\ThemeDetail;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\web\Response;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
{

    private $billingCycleList = Enrolment::BILLING_CYCLE_LIST;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-service')){

            $searchModel        = new ServiceSearch();
            $staffList          = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
            $serviceTypeList    = Service::getArrayServiceType();

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'staffList'=>$staffList,
                'serviceTypeList'=>$serviceTypeList
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Service model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        if(Yii::$app->user->can('view-service')){
            $model              = $this->findModel($id);
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $staffList          = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');
            $serviceTypeList    = Service::getArrayServiceType();

            ////////////////////////////////////////////////////////////////////
            //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
            $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
            $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();

            $providerServiceDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->serviceDetails,
            ]);
            return $this->render('view', [
                'model'                 => $this->findModel($id),
                'providerServiceDetail' => $providerServiceDetail,
                'customerList'          => $customerList,
                'staffList'             => $staffList,
                'customer'              => $customer,
                'enrolment'             => $enrolment,
                'serviceTypeList'       => $serviceTypeList
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     * JIKA SUDAH DIGITAL, SERVICE OTOMATIS PERPANJANG/EXTEND
     * CEK JUGA VAR &DAYS, JIKA !NULL ATUR DATE START DAN END NYA
     *
     * TYPE = SERVICE TYPE
     */
    public function actionCreate($id, $type, $title=null, $days=null)
    {
        if(Yii::$app->user->can('create-service')){
            $formatter              = \Yii::$app->formatter;

            $customerList           = ArrayHelper::map(Customer::find()->where(['id'=>$id])->asArray()->all(), 'id','title');
            $staffList              = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');
            $serviceTypeList        = Service::getArrayServiceType();
            $enrolment              = Enrolment::find()->where(['customer_id'=>$id])->one();

            $model                  = new Service();
            $model->customer_id     = $id;
            $model->service_type    = $type;
            $model->billing_cycle   = $enrolment->billing_cycle;
            $model->date_issued     = time();
            $model->date_effective  = time();
            $model->date_start      = time();
            $model->date_end        = strtotime ('30 day',  $model->date_start);
            $model->claim           = 0;
            $model->surcharge       = 0;
            $model->total           = 0;

            if($type == Service::SERVICE_TYPE_GENERAL){
                $model->service_type = Service::SERVICE_TYPE_GENERAL;
            }
            else if($type == Service::SERVICE_TYPE_CHANGE_TO_DIGITAL){
                $model->service_type = Service::SERVICE_TYPE_CHANGE_TO_DIGITAL;
                $model->claim        = $formatter->asDecimal($model->customer->sumMonthlyBill());
            }
            else if($type == Service::SERVICE_TYPE_EXTEND_DIGITAL){
                $model->service_type    = Service::SERVICE_TYPE_EXTEND_DIGITAL;
                $model->claim           = $formatter->asDecimal($model->customer->sumMonthlyBill());
                $model->total           = $model->claim;
                $model->date_start      = strtotime ('1 day',  $enrolment->date_end);
                $model->date_end        = strtotime ('30 day',  $model->date_start);

                if(!empty($days)){
                    $model->date_start  = $enrolment->date_end;
                    $model->date_end    = strtotime ($days.' day',  $model->date_start);
                }
            }

            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($model->serviceDetails);
            }

            if ($model->loadAll(Yii::$app->request->post())) {
           
                $transaction = \Yii::$app->db->beginTransaction();
                try
                {
                    $model->saveAll();
                    
                    ////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////
                    //UPDATE DATA ENROLMENT
                    //UPDATE DATA OUTLET DETAIL
                    if($model->total > 0 && $model->service_type == Service::SERVICE_TYPE_CHANGE_TO_DIGITAL){

                        $model->addDigitalValidityBilling($model->service_type);

                        //UBAH JENIS LANGGANAN JADI DIGITAL
                        $enrolment->enrolment_type  = Enrolment::ENROLMENT_TYPE_DIGITAL;
                        $enrolment->billing_cycle   = Enrolment::setBillingCycle($model->date_start);
                        $enrolment->date_start      = $model->date_start;
                        $enrolment->date_end        = $model->date_end;
                        $enrolment->save();

                        $outletDetails = OutletDetail::find()->where([
                            'customer_id'=>$enrolment->customer_id,
                        ])->all();

                        foreach ($outletDetails as $outletDetailModel) {
                            $outletDetailModel->enrolment_type = $enrolment->enrolment_type;

                            $serviceDetail = ServiceDetail::find()->where(['outlet_detail_id'=>$outletDetailModel->id])->one();
                            $outletDetailModel->monthly_bill = $serviceDetail->monthly_bill;

                            $outletDetailModel->save();
                        }
                    }

                    //PERPANJANG SAJA
                    elseif($model->total > 0 && $model->service_type==Service::SERVICE_TYPE_EXTEND_DIGITAL){

                        $model->addDigitalValidityBilling($model->service_type);

                        $enrolment->billing_cycle   = Enrolment::setBillingCycle($model->date_start);
                        $enrolment->date_start      = $model->date_start;
                        $enrolment->date_end        = $model->date_end;
                        $enrolment->save();
                    }

                    elseif($model->total > 0 && $model->service_type==Service::SERVICE_TYPE_GENERAL){
                        $model->updateValidityAndBilling();
                    }

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);

                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
            else {

                $serviceDetails    = [];

                ////////////////////////////////////////////////////////////////////
                //CREDIT / HUTANG / BELUM PERNAH BAYAR
                $outletDetails   = OutletDetail::find()
                        ->where(['customer_id'=>$id])
                        ->andWhere(['<>', 'device_status', OutletDetail::DEVICE_STATUS_DISCONNECT])
                        ->all();

                foreach ($outletDetails as $outletDetailModel) {
                    $commentary =  $outletDetailModel->getOneDeviceType($outletDetailModel->device_type). ' | '.
                                    $outletDetailModel->getOneDeviceStatus($outletDetailModel->device_status).' | '.
                                    $formatter->asDecimal($outletDetailModel->monthly_bill);

                    $serviceDetails[]=[
                        'outlet_detail_id'  => $outletDetailModel->id,
                        'service_reason_id' => '',
                        'device_status'     => $outletDetailModel->device_status,
                        'monthly_bill'      => $formatter->asDecimal($outletDetailModel->monthly_bill),
                        'commentary'        => strip_tags($commentary),
                        'description'       => $commentary //FOR DISPLAY
                    ];

                }

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
                $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();

                return $this->render('create', [
                    'model' => $model,
                    'customerList'=>$customerList,
                    'staffList'=>$staffList,
                    'serviceDetails'=>$serviceDetails,

                    'customer'=>$customer,
                    'enrolment'=>$enrolment,
                    'serviceTypeList'=>$serviceTypeList,

                    'type'=>$type,
                    'billingCycleList'=>$this->billingCycleList,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-service')){
            $formatter          = Yii::$app->formatter;
            $model              = $this->findModel($id);
            $model->total       = $formatter->asDecimal($model->total);
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $staffList          = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');
            $serviceTypeList    = Service::getArrayServiceType();

            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($model->serviceDetails);
            }

            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                $model->updateValidityAndBilling();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                $allServiceDetails   = \backend\models\ServiceDetail::findAll(['service_id'=>$id]);
                $serviceDetails[]=[];
                foreach ($allServiceDetails as $allServiceDetailModel) {

                    //DUMMY TIDAK DISIMPAN DALAM DATABASE
                    $description = '#'.$allServiceDetailModel->serviceReason->title. ' | '.
                                    $allServiceDetailModel->getOneDeviceStatus($allServiceDetailModel->device_status);

                    $serviceDetails[]=[
                        'id'                => $allServiceDetailModel->id,
                        'outlet_detail_id'  => $allServiceDetailModel->outlet_detail_id,
                        'service_reason_id' => $allServiceDetailModel->service_reason_id,
                        'device_status'     => $allServiceDetailModel->device_status,
                        'monthly_bill'      => $formatter->asDecimal($allServiceDetailModel->monthly_bill),
                        'description'       => $description //DUMMY TIDAK DISIMPAN DALAM DATABASE
                    ];

                }

                //HAPUS ELEMEN 0 KARENA NILAINYA NULL
                //SUPAYA TAMPILAN FORM TIDAK ADA TAMBAHAN
                //FORM DETAIL YANG KOSONG
                array_shift($serviceDetails);



                return $this->render('update', [
                    'model' => $model,
                    'customerList'=>$customerList,
                    'staffList'=>$staffList,
                    'serviceDetails'=>$serviceDetails,
                    'serviceTypeList'=>$serviceTypeList,
                    'billingCycleList'=>$this->billingCycleList,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-service')){

            $model = $this->findModel($id);
            $serviceDetails = ServiceDetail::find()->where(['service_id'=>$model->id])->all();

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($serviceDetails as $serviceDetailModel) {
                    $serviceDetailModel->delete();
                }
                $model->delete();
                $transaction->commit();

                return $this->redirect(['index']);

            }
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     *
     * Export Service information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerServiceDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->serviceDetails,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerServiceDetail' => $providerServiceDetail,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }


    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
    * Action to load a tabular form grid
    * for ServiceDetail
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddServiceDetail()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ServiceDetail');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formServiceDetail', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInvoice($id){
        if(Yii::$app->user->can('view-service')){
            $model      = $this->findModel($id);
            $enrolment  = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();
            $providerServiceDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->serviceDetails,
            ]);

            $office         = Office::findOne(1);
            $logoReport1    = ThemeDetail::getByToken(Yii::$app->params['ContentToken_LogoReport_1']);
            $descReport     = ThemeDetail::getByToken(Yii::$app->params['ContentToken_DescReport']);

            return $this->render('invoice', [
                'model'                     => $model,
                'enrolment'                 => $enrolment,
                'providerServiceDetail'     => $providerServiceDetail,
                'office'                    => $office,
                'logoReport1'               => $logoReport1,
                'descReport'                => $descReport
            ]);
        }
        else {
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }
}
