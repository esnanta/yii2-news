<?php

namespace backend\controllers;

use Yii;
use backend\models\Receivable;
use backend\models\ReceivableSearch;
use backend\models\ReceivableDetail;
use backend\models\Billing;
use backend\models\Customer;
use backend\models\Enrolment;
use backend\models\Staff;
use backend\models\Office;
use backend\models\ThemeDetail;

use common\helper\Helper;

use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use kartik\widgets\ActiveForm;
use yii\web\Response;
/**
 * ReceivableController implements the CRUD actions for Receivable model.
 */
class ReceivableController extends Controller
{
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
     * Lists all Receivable models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-receivable')){

            $searchModel = new ReceivableSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize=10;

            $staffList      = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'staffList' => $staffList
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Displays a single Receivable model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-receivable')){
            $model = $this->findModel($id);
            $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();
            $providerReceivableDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->receivableDetails,
            ]);

            $customerList   = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $staffList      = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');

            return $this->render('view', [
                'model'                     => $model,
                'enrolment'                 => $enrolment,
                'providerReceivableDetail'  => $providerReceivableDetail,
                'customerList'              => $customerList,
                'staffList'                 => $staffList
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Creates a new Receivable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if(Yii::$app->user->can('create-receivable')){
            $model = new Receivable();
            $model->date_issued    = time();
            $model->customer_id    = $id;

            $customerList   = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $staffList      = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');

            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($model->receivableDetails);
            }

            if ($model->loadAll(Yii::$app->request->post()) && Model::validateMultiple([$model])) {

                foreach ($model->receivableDetails as $detailModel) {
                    if($detailModel->validate()==false){

                        Yii::$app->getSession()->setFlash('danger', [
                            'message' => Yii::t('app', Html::encode('Input detail harap diisi dengan benar.'))
                        ]);

                        return $this->render('create', [
                            'model' => $model,
                            'customerList' => $customerList,
                            'staffList' => $staffList  ,
                            'receivableDetails'=>$model->receivableDetails
                        ]);
                    }
                }

                $transaction = \Yii::$app->db->beginTransaction();
                try
                {
                    $model->saveAll();

                    $masterPayment = ($model->payment+$model->discount) - ($model->penalty+$model->surcharge) ;

                    foreach ($model->receivableDetails as $receivableDetailModel) {

                        $billing = Billing::find()->where(['id' => $receivableDetailModel->billing_id])->one();

                        //LUNAS = JUMLAH PEMBAYARAN LEBIH BESAR DARI ATAU SAMA DENGAN TAGIHAN
                        //DETAIL TOTAL = DETAIL TOTAL - DETAIL PENALTY
                        //KARENA NILAI MASTERPAYMENT SUDAH DIKURANGI DENGAN NILAI TOTAL DETAIL PENALTY
                        $detailTotal = ($receivableDetailModel->total-$receivableDetailModel->penalty);
                        if($masterPayment >= $detailTotal){
                            $receivableDetailModel->payment = $detailTotal;
                            $receivableDetailModel->balance = 0;
                            $masterPayment = $masterPayment-$detailTotal;

                            $billing->payment_status = Billing::PAYMENT_STATUS_PAID;
                        }
                        //HUTANG = JUMLAH BAYAR TERSISA LEBIH KECIL
                        //MASUKKAN SISA UANG YANG ADA KE DALAM DATA PEMBAYARAN
                        else if($masterPayment < $detailTotal){
                            $receivableDetailModel->payment = $masterPayment;
                            $receivableDetailModel->balance = $masterPayment-$detailTotal;
                            $masterPayment = 0;

                            $billing->payment_status = Billing::PAYMENT_STATUS_INSTALLMENT;
                        }

                        $receivableDetailModel->save();
                        $billing->save();
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

                $totalClaim = 0;

                $formatter = \Yii::$app->formatter;
                $receivableDetails = [];

                $accuracyStatusOverdue = ReceivableDetail::ACCURACY_STATUS_OVERDUE;

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
                $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();


                ////////////////////////////////////////////////////////////////////
                //CREDIT / HUTANG / BELUM PERNAH BAYAR
                $billingCredits   = Billing::find()->where([
                    'customer_id'=>$id,
                    'payment_status'=> Billing::PAYMENT_STATUS_CREDIT
                ])
                ->orderBy(['date_due'=>SORT_ASC])
                ->all();

                foreach ($billingCredits as $billingCreditModel) {

                    $totalClaim = $totalClaim+$billingCreditModel->amount;

                    //DUMMY TIDAK DISIMPAN DALAM DATABASE
                    $link               = Html::a('<i class="fa fa-eye"></i>',$billingCreditModel->getUrl());
                    $monthPeriodLabel   = '<span class="label label-success">'.$billingCreditModel->month_period.'</span>';
                    $description = $link.' '.$billingCreditModel->getOneBillingType($billingCreditModel->billing_type).' '.
                                        $monthPeriodLabel. ' OVD :'.
                                        Helper::getOverdue(time(), $billingCreditModel->date_due).' hari. ';

                    $billingCreditModel->amount = (!empty($billingCreditModel->amount)) ? $billingCreditModel->amount : 0;

                    $receivableDetails[]=[
                        'billing_id'        => $billingCreditModel->id,
                        'date_due'          => $billingCreditModel->date_due,
                        'overdue'           => Helper::getOverdue(time(), $billingCreditModel->date_due),
                        'accuracy_status'   => $accuracyStatusOverdue,
                        'penalty'           => 0,
                        'claim'             => $formatter->asDecimal($billingCreditModel->amount),
                        'total'             => $formatter->asDecimal($billingCreditModel->amount),
                        'payment'           => 0,
                        'balance'           => 0,
                        'description'       => $description //DUMMY TIDAK DISIMPAN DALAM DATABASE

                    ];
                }

                ////////////////////////////////////////////////////////////////////
                //INSTALLMENT / CICILAN / SUDAH PERNAH BAYAR
                $billingInstallments = Billing::find()->where([
                    'customer_id'=>$id,
                    'payment_status'=> Billing::PAYMENT_STATUS_INSTALLMENT
                ])->all();

                foreach ($billingInstallments as $billingInstallmentModel) {

                    $amount     = $billingInstallmentModel->amount;
                    $totalClaim = $totalClaim + $billingInstallmentModel->amount;

                    $receivableDetailsCheck = ReceivableDetail::find()->where(['billing_id'=>$billingInstallmentModel->id])->all();
                    foreach ($receivableDetailsCheck as $receivableDetailModel) {
                        $amount     = $amount - $receivableDetailModel->payment;
                        $totalClaim = $totalClaim - $receivableDetailModel->payment;
                    }

                    //DUMMY TIDAK DISIMPAN DALAM DATABASE
                    $description = $billingInstallmentModel->getOneBillingType($billingInstallmentModel->billing_type).' #'.
                                        $billingInstallmentModel->invoice. ' Overdue :'.
                                        Helper::getOverdue(time(), $billingInstallmentModel->date_due);

                    $receivableDetails[]=[
                        'billing_id'        => $billingInstallmentModel->id,
                        'date_due'          => $billingInstallmentModel->date_due,
                        'overdue'           => 0,
                        'accuracy_status'    => $accuracyStatusOverdue,
                        'penalty'           => 0,
                        'claim'             => $formatter->asDecimal($amount),
                        'total'             => $formatter->asDecimal($amount),
                        'payment'           => 0,
                        'balance'           => 0,
                        'description'       => $description //DUMMY TIDAK DISIMPAN DALAM DATABASE

                    ];
                }

                ////////////////////////////////////////////////////////////////////


                $model->claim       = $formatter->asDecimal($totalClaim);
                $model->surcharge   = 0;
                $model->penalty     = 0;
                $model->total       = $formatter->asDecimal($totalClaim);
                $model->discount    = 0;
                $model->payment     = 0;
                $model->balance     = $formatter->asDecimal((0-$totalClaim));

                return $this->render('create', [
                    'model'             => $model,
                    'customerList'      => $customerList,
                    'staffList'         => $staffList  ,
                    'receivableDetails' => $receivableDetails,
                    'customer'          => $customer,
                    'enrolment'         => $enrolment
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Updates an existing Receivable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        Yii::$app->session->setFlash('error', 'Update has been disabled.');
        throw new ForbiddenHttpException;

//        if(Yii::$app->user->can('update-receivable')){
//            $model = $this->findModel($id);
//            $customerList   = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
//            $staffList      = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
//
//            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ActiveForm::validateMultiple($model->receivableDetails);
//            }
//
//            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            } else {
//
//                $formatter = \Yii::$app->formatter;
//                $model->claim = $formatter->asDecimal($model->claim);
//                $model->surcharge = $formatter->asDecimal($model->surcharge);
//                $model->penalty = $formatter->asDecimal($model->penalty);
//                $model->total = $formatter->asDecimal($model->total);
//                $model->discount = $formatter->asDecimal($model->discount);
//                $model->payment = $formatter->asDecimal($model->payment);
//                $model->balance = $formatter->asDecimal($model->balance);
//
//                $allRecevableDetails   = ReceivableDetail::findAll(['receivable_id'=>$id]);
//                $receivableDetails[]=[];
//                foreach ($allRecevableDetails as $allRecevableDetailModel) {
//                    $receivableDetails[]=[
//                        'id'                => $allRecevableDetailModel->id,
//                        'billing_id'        => $allRecevableDetailModel->billing_id,
//                        'title'             => $allRecevableDetailModel->title,
//                        'date_due'          => $allRecevableDetailModel->date_due,
//                        'overdue'           => $allRecevableDetailModel->overdue,
//                        'accuracy_status'    => $allRecevableDetailModel->accuracy_status,
//                        'penalty'           => $formatter->asDecimal($allRecevableDetailModel->penalty),
//                        'claim'             => $formatter->asDecimal($allRecevableDetailModel->claim),
//                        'total'             => $formatter->asDecimal($allRecevableDetailModel->total),
//                        'payment'           => $formatter->asDecimal($allRecevableDetailModel->payment),
//                        'balance'           => $formatter->asDecimal($allRecevableDetailModel->balance),
//
//                    ];
//                }
//
//                //HAPUS ELEMEN 0 KARENA NILAINYA NULL
//                //SUPAYA TAMPILAN FORM TIDAK ADA TAMBAHAN
//                //FORM DETAIL YANG KOSONG
//                array_shift($receivableDetails);
//
//                return $this->render('update', [
//                    'model' => $model,
//                    'customerList' => $customerList,
//                    'staffList' => $staffList,
//                    'receivableDetails'=>$receivableDetails
//                ]);
//            }
//        }
//        else{
//            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
//            throw new ForbiddenHttpException;
//        }

    }

    /**
     * Deletes an existing Receivable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-receivable')){
            $model = $this->findModel($id);
            //$this->findModel($id)->deleteWithRelated();

            $receivableDetails = ReceivableDetail::find()->where(['receivable_id'=>$model->id])->all();

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($receivableDetails as $receivableDetailModel) {
                    $receivableDetailModel->delete();
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
     * Export Receivable information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerReceivableDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->receivableDetails,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerReceivableDetail' => $providerReceivableDetail,
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
     * Finds the Receivable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receivable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Receivable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
    * Action to load a tabular form grid
    * for ReceivableDetail
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddReceivableDetail()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ReceivableDetail');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formReceivableDetail', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInvoice($id){
        if(Yii::$app->user->can('view-receivable')){
            $model      = $this->findModel($id);
            $enrolment  = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();
            $providerReceivableDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->receivableDetails,
            ]);

            $office         = Office::findOne(1);
            $logoReport1    = ThemeDetail::getByToken(Yii::$app->params['ContentToken_LogoReport_1']);
            $descReport     = ThemeDetail::getByToken(Yii::$app->params['ContentToken_DescReport']);

            return $this->render('invoice', [
                'model'                     => $model,
                'enrolment'                 => $enrolment,
                'providerReceivableDetail'  => $providerReceivableDetail,
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
