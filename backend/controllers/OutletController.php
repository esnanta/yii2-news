<?php

namespace backend\controllers;

use Yii;
use backend\models\Outlet;
use backend\models\OutletNew;
use backend\models\OutletSearch;
use backend\models\OutletDetail;
use backend\models\Customer;
use backend\models\Staff;
use backend\models\Billing;
use backend\models\Counter;
use backend\models\Enrolment;
use backend\models\Network;
use backend\models\Office;
use backend\models\ThemeDetail;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use yii\helpers\Html;
use yii\base\Model;

use kartik\widgets\ActiveForm;
use yii\web\Response;
/**
 * OutletController implements the CRUD actions for Outlet model.
 */
class OutletController extends Controller
{
    
    private $billingCycleList=[
            '01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05',
            '06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10',
            '11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15',
            '16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
            '21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25',
            '26'=>'26','27'=>'27','28'=>'28'];    
    
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
     * Lists all Outlet models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-outlet')){
            $searchModel        = new OutletSearch();
            $staffList          = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
            $billingStatusList  = Outlet::getArrayBillingStatus();
            $assemblyTypeList   = Outlet::getArrayAssemblyType();

            $dataProvider       = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize=10;
            
            return $this->render('index', [
                'searchModel'       => $searchModel,
                'dataProvider'      => $dataProvider,
                'staffList'         => $staffList,
                'billingStatusList' => $billingStatusList,
                'assemblyTypeList'  => $assemblyTypeList
            ]);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }   

    }

    /**
     * Displays a single Outlet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-outlet')){
            $model              = $this->findModel($id);
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $billingStatusList  = Outlet::getArrayBillingStatus();
            $assemblyTypeList   = Outlet::getArrayAssemblyType();

            $staffList          = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');           
                        
            ////////////////////////////////////////////////////////////////////
            //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
            $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
            $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();               
            
            $providerOutletDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->outletDetails,
            ]);
            return $this->render('view', [
                'model' => $this->findModel($id),
                'providerOutletDetail' => $providerOutletDetail,
                'customerList'=>$customerList,
                'staffList'=>$staffList,
                'billingStatusList'=>$billingStatusList,
                'assemblyTypeList'=>$assemblyTypeList,
                'customer'          => $customer,
                'enrolment'         => $enrolment,                 
            ]);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
        
    }

    /**
     * Creates a new Outlet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if(Yii::$app->user->can('create-outlet')){
            $model                  = new OutletNew();
            $customer               = Customer::find()->where(['id'=>$id])->one();
            
            $model->customer_id     = $customer->id;
            $model->date_issued     = $customer->date_issued;
            $model->date_assembly   = $customer->date_issued;
            $model->date_effective  = $customer->date_issued;
            
            $model->date_start      = $customer->date_issued;
            $model->date_end        = strtotime ( '30 day' , $customer->date_issued);
            
            $model->enrolment_type  = Enrolment::ENROLMENT_TYPE_DIGITAL;
            $model->billing_cycle   = Enrolment::setBillingCycle($model->date_effective);
                                        
            $checkEnrolment         = Enrolment::find()->where(['customer_id'=>$id])->one();
            if(!empty($checkEnrolment)){
                $model->billing_cycle               = $checkEnrolment->billing_cycle;
                $model->network_tags_title          = $checkEnrolment->network->title;
            }
            
            $nextNumber             = Counter::getNextNumber(Counter::COUNTER_OF_ENROLMENT);

            $customerList           = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id', 'title');
            $networkTitleList       = Network::getArrayTitleList();
            $billingStatusList      = Outlet::getArrayBillingStatus();
            $assemblyTypeList       = Outlet::getArrayAssemblyType();
            $enrolmentTypeList      = Enrolment::getArrayEnrolmentType();

            $paymentStatusCredit    = Billing::PAYMENT_STATUS_CREDIT;         
            $staffList              = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');                                        
                                    
            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($model->outletDetails);
            }          

            if ($model->loadAll(Yii::$app->request->post()) && Model::validateMultiple([$model])) {

                //VALIDASI DULU
                foreach ($model->outletDetails as $detailModel) {
                    if($detailModel->validate()==false){

                        Yii::$app->getSession()->setFlash('danger', [
                            'message' => Yii::t('app', Html::encode('Input detail harap diisi dengan benar.'))
                        ]);                     

                        return $this->render('create', [
                            'model'             => $model,     
                            'checkEnrolment'    => $checkEnrolment,
                            'nextNumber'        => $nextNumber,
                            'customerList'      => $customerList,
                            'staffList'         => $staffList,
                            'billingStatusList' => $billingStatusList,
                            'networkTitleList'  => $networkTitleList,
                            'assemblyTypeList'  => $assemblyTypeList,
                            'outletDetails'     => $model->outletDetails,
                            'billingCycleList'  => $this->billingCycleList
                        ]);                    
                    }
                    
                    //PASTIKAN ENROLMENT TYPE NYA SAMA DENGAN MASTER
                    //SECARA FISIK ENROLMENT TYPE HANYA 
                    //ADA DI DETAIL, TIDAK ADA DI MASTER
                    else{
                        $detailModel->enrolment_type = $model->enrolment_type;
                    }
                }
                //AKHIR VALIDASI
                
                $transaction = \Yii::$app->db->beginTransaction();
                try 
                {  
                    $model->saveAll();
                    $model->description = '';
                    $model->claim = $model->getTotalAssemblyCost()+$model->getTotalMonthlyBill();
                    $model->save();
                    ////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////
                    //BUAT ENROLMENT KALAU BELUM ADA     
                    ////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////                

                    if(empty($checkEnrolment)){
                        $enrolment                          = new Enrolment;
                        $enrolment->customer_id             = $id;
                        $enrolment->network_tags_title      = $model->network_tags_title;
                        $enrolment->date_effective          = $model->date_effective;
                        $enrolment->billing_cycle           = $model->billing_cycle;
                        $enrolment->enrolment_type          = $model->enrolment_type;
                        $enrolment->date_start              = $model->date_start;
                        $enrolment->date_end                = $model->date_end;
                        
                        $enrolment->save();
                    } 
 
                    /* CATATAN TENTANG PEMBUATAN TAGIHAN
                     * 
                     * PEMBUATAN TAGIHAN PERDANA VIA OUTLET TIDAK DIPISAH ANTARA IURAN DAN BIAYA PEMASANGAN
                     * JIKA DIPISAH, BAGAIMANA NANTI PERLAKUAN UNTUK TAMBAHAN OUTLET DI TENGAH JALAN
                     */
                    
                    ////////////////////////////////////////////////////////////////
                    //TAGIHAN PEMASANGAN BERDASARKAN MASTER DATA OUTLET     
                    ////////////////////////////////////////////////////////////////                
                    $billingType              = $model->getBillingTypeFromAssembly();

                    $billing                  = new Billing;
                    $billing->customer_id     = $model->customer_id;
                    $billing->title           = Counter::getSerialNumber(Counter::CODE_OF_BILLING);
                    $billing->invoice         = $model->title;
                    $billing->amount          = $model->claim;
                    $billing->date_issued     = $model->date_effective;
                    $billing->date_due        = Helper::getDue($model->date_effective);
                    
                    //INGAT, TAGIHAN IURAN DIBEBANKAN SAAT PEMASANGAN
                    //SCRIPT BERIKUT ADALAH UNTUK MENENTUKAN PERIODE BULAN SAJA
                    //JIKA TANGGAL EFEKTIF LEBIH BESAR DARI 28, MAKA IURAN YANG 
                    //BERLAKU ADALAH BULAN BERIKUTNYA
                    $hari           = (int) (date('d',$model->date_effective));
                    $monthPeriod    = Helper::getMonthPeriod($model->date_effective);
                    if($hari > 28){
                        $newDate     = strtotime ( '+1 month' , $model->date_effective ) ;
                        $monthPeriod = Helper::getMonthPeriod($newDate);
                    }                    
                    
                    $billing->month_period    = $monthPeriod;
                    $billing->billing_type    = $billingType;
                    $billing->payment_status  = $paymentStatusCredit;
                    $billing->description     = $model->getSummary().' + 1 bulan iuran '.$monthPeriod;
                    $billing->save();

                    $model->billing_status    = Outlet::BILLING_STATUS_YES;
                    $model->save();

                    $transaction->commit();
                    return $this->redirect(['customer/view', 'id' => $model->customer_id]);

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
                $formatter = \Yii::$app->formatter;
                
                $deviceType = (empty($checkEnrolment)) ? 
                                OutletDetail::DEVICE_TYPE_MAIN:
                                OutletDetail::DEVICE_TYPE_PARALEL;
                
                $monthlyBill = (empty($checkEnrolment)) ? 
                                $formatter->asDecimal(65000):
                                $formatter->asDecimal(15000);
                
                $assemblyCost = (empty($checkEnrolment)) ? 
                                $formatter->asDecimal(250000):
                                $formatter->asDecimal(50000);   
                
                $model->claim = (empty($checkEnrolment)) ? 
                                $formatter->asDecimal(250000+65000):
                                $formatter->asDecimal(50000+15000);                   
                
                $outletDetails [] = [
                    'device_type'        => $deviceType,
                    'monthly_bill'       => $monthlyBill,
                    'assembly_cost'      => $assemblyCost,
                ];                
                
                
                return $this->render('create', [
                    'model'             => $model,     
                    'checkEnrolment'    => $checkEnrolment,
                    'nextNumber'        => $nextNumber,
                    'customerList'      => $customerList,
                    'staffList'         => $staffList,
                    'billingStatusList' => $billingStatusList,
                    'networkTitleList'  => $networkTitleList,
                    'assemblyTypeList'  => $assemblyTypeList,
                    'enrolmentTypeList' => $enrolmentTypeList,
                    'outletDetails'     => $outletDetails,//$model->outletDetails
                    'billingCycleList'  => $this->billingCycleList
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }        
        
    }

    /**
     * Updates an existing Outlet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-outlet')){
            $model = $this->findModel($id);
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $billingStatusList      = Outlet::getArrayBillingStatus();
            $assemblyTypeList       = Outlet::getArrayAssemblyType();
       
            $staffList  = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');           
            
            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($model->outletDetails);
            }           

            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {


                $formatter = \Yii::$app->formatter;
                $model->claim = $formatter->asDecimal($model->claim);

                $allOutletDetails   = OutletDetail::findAll(['outlet_id'=>$id]);
                $outletDetails[]=[];
                foreach ($allOutletDetails as $allOutletDetailModel) {
                    $outletDetails[]=[
                        'id'                => $allOutletDetailModel->id,
                        'device_type'       => $allOutletDetailModel->device_type,
                        'device_status'     => $allOutletDetailModel->device_status,
                        'monthly_bill'      => $formatter->asDecimal($allOutletDetailModel->monthly_bill),
                        'assembly_cost'     => $formatter->asDecimal($allOutletDetailModel->assembly_cost),
                        'verlock'           => $allOutletDetailModel->verlock,
                    ];
                }              

                //HAPUS ELEMEN 0 KARENA NILAINYA NULL
                //SUPAYA TAMPILAN FORM TIDAK ADA TAMBAHAN
                //FORM DETAIL YANG KOSONG
                array_shift($outletDetails);            

                return $this->render('update', [
                    'model' => $model,    
                    'customerList'=>$customerList,
                    'staffList'=>$staffList,
                    'billingStatusList'=>$billingStatusList,
                    'assemblyTypeList'=>$assemblyTypeList,
                    'outletDetails'=>$outletDetails
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
        
    }

    /**
     * Deletes an existing Outlet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-outlet')){
            $model = $this->findModel($id);

            if($model->billing_status == Outlet::BILLING_STATUS_YES){
                $billing = Billing::find()->where(['invoice'=>$model->title])->one();
                $url = Html::a($billing->title, $billing->getUrl());
                Yii::$app->getSession()->setFlash('danger', [
                    'message' => Yii::t('app', 'Tidak bisa menghapus data karena ada tagihan . ('.$url.')'),
                ]); 
                return $this->redirect(['site/message']);
            }
            else{
                $model->deleteWithRelated();
                $model->adjustValidityAndBilling();
                
                Yii::$app->getSession()->setFlash('success', [
                    'message' => Yii::t('app', 'Data berhasil dihapus'),
                ]);     
                
                return $this->redirect(['index']);
            }      
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }   
    }
    
    /**
     * 
     * Export Outlet information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerOutletDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->outletDetails,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerOutletDetail' => $providerOutletDetail,
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
     * Finds the Outlet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Outlet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Outlet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for OutletDetail
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddOutletDetail()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('OutletDetail');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formOutletDetail', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionInvoice($id){
        if(Yii::$app->user->can('view-outlet')){
            $model      = $this->findModel($id);
            $enrolment  = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();
            $providerOutletDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->outletDetails,
            ]);

            $office         = Office::findOne(1);
            $logoReport1    = ThemeDetail::getByToken(Yii::$app->params['ContentToken_LogoReport_1']);
            $descReport     = ThemeDetail::getByToken(Yii::$app->params['ContentToken_DescReport']);

            return $this->render('invoice', [
                'model'                     => $model,
                'enrolment'                 => $enrolment,
                'providerOutletDetail'      => $providerOutletDetail,
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
