<?php

namespace backend\controllers;

use Yii;
use backend\models\Validity;
use backend\models\ValiditySearch;
use backend\models\ValidityDetail;
use backend\models\OutletDetail;
use backend\models\Enrolment;
use backend\models\Counter;

use common\helper\Helper;

use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * ValidityController implements the CRUD actions for Validity model.
 */
class ValidityController extends Controller
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
     * Lists all Validity models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-validity')){

            $searchModel = new ValiditySearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Creates a new Validity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-validity')){
            $model              = new Validity;
            $monthPeriodList    = Validity::getMonthPeriod();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'monthPeriodList'=>$monthPeriodList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Updates an existing Validity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-validity')){
            $model              = $this->findModel($id);
            $monthPeriodList    = Validity::getMonthPeriod();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'monthPeriodList'=>$monthPeriodList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    public function actionReset($id)
    {
        if(Yii::$app->user->can('update-validity')){
            $model              = $this->findModel($id);

            $model->counter     = 0;
            $model->description = '-';
            $model->save();

            Yii::$app->getSession()->setFlash('success', [
                'message' => Yii::t('app', Html::encode('Counter reset 0.')),
            ]);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Deletes an existing Validity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        if(Yii::$app->user->can('delete-validity')){
            $model = $this->findModel($id);

            $transaction = \Yii::$app->db->beginTransaction();
            try {

                \backend\models\ValidityDetail::deleteAll(['validity_id'=>$model->id]);
                $model->delete();
                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'message' => Yii::t('app', Html::encode('Data berhasil dihapus.')),
                ]);

                return $this->redirect(['index']);
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
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
     * Finds the Validity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Validity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Validity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Validity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-validity')){

            $model                          = $this->findModel($id);

            $monthPeriodList                = Validity::getMonthPeriod();
            $currMonthPeriod                = Helper::getMonthPeriod(time());

            $billingStatusNo                = ValidityDetail::BILLING_STATUS_NO;
            $billingStatusYes               = ValidityDetail::BILLING_STATUS_YES;
            $deviceStatusActive             = ValidityDetail::DEVICE_STATUS_ACTIVE;
            $deviceStatusFree               = ValidityDetail::DEVICE_STATUS_FREE;
            $deviceStatusIdle               = ValidityDetail::DEVICE_STATUS_IDLE;

            $countBillingStatusNo           = $model->countByBillingStatus($billingStatusNo);
            $countBillingStatusYes          = $model->countByBillingStatus($billingStatusYes);

            $countDeviceStatusActive        = $model->countByDeviceStatus($deviceStatusActive);
            $countDeviceStatusFree          = $model->countByDeviceStatus($deviceStatusFree);
            $countDeviceStatusIdle          = $model->countByDeviceStatus($deviceStatusIdle);

            $percentBillingStatusNo         = Helper::getPercent($countBillingStatusNo, $countBillingStatusNo+$countBillingStatusYes);
            $percentBillingStatusYes        = Helper::getPercent($countBillingStatusYes, $countBillingStatusNo+$countBillingStatusYes);

            $percentDeviceStatusActive      = Helper::getPercent($countDeviceStatusActive, $countDeviceStatusActive+$countDeviceStatusFree+$countDeviceStatusIdle);
            $percentDeviceStatusFree        = Helper::getPercent($countDeviceStatusFree, $countDeviceStatusActive+$countDeviceStatusFree+$countDeviceStatusIdle);
            $percentDeviceStatusIdle        = Helper::getPercent($countDeviceStatusIdle, $countDeviceStatusActive+$countDeviceStatusFree+$countDeviceStatusIdle);

            $percentBillingDispensationFree = Helper::getPercent($countDeviceStatusFree, $countDeviceStatusFree+$countDeviceStatusIdle);
            $percentBillingDispensationIdle = Helper::getPercent($countDeviceStatusIdle, $countDeviceStatusFree+$countDeviceStatusIdle);

            $linkDeviceActive = Html::a('<i class="fa fa-print"></i>', [
                'report-validity/period','month'=>$model->title,
                'attribute' => 'device_status',
                'value' => $deviceStatusActive
            ]);

            $linkDeviceFree = Html::a('<i class="fa fa-print"></i>', [
                'report-validity/period','month'=>$model->title,
                'attribute' => 'device_status',
                'value' => $deviceStatusFree
            ]);

            $linkDeviceIdle = Html::a('<i class="fa fa-print"></i>', [
                'report-validity/period','month'=>$model->title,
                'attribute' => 'device_status',
                'value' => $deviceStatusIdle
            ]);

            $linkBillingYes = Html::a('<i class="fa fa-print"></i>', [
                'report-validity/period','month'=>$model->title,
                'attribute' => 'billing_status',
                'value' => $billingStatusYes
            ]);

            $linkBillingNo = Html::a('<i class="fa fa-print"></i>', [
                'report-validity/period','month'=>$model->title,
                'attribute' => 'billing_status',
                'value' => $billingStatusNo
            ]);

            $countOutletActive      = OutletDetail::getDistinctDevicesWithoutDC()->count();
            $countCustomerActive    = OutletDetail::getDistinctDevicesByActive()->count();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'currMonthPeriod'=>$currMonthPeriod,
                    'monthPeriodList'=>$monthPeriodList,

                    'countOutletActive'=>$countOutletActive,
                    'countCustomerActive'=>$countCustomerActive,

                    'countBillingStatusYes'=>$countBillingStatusYes,
                    'countBillingStatusNo'=>$countBillingStatusNo,

                    'percentBillingStatusNo'=>$percentBillingStatusNo,
                    'percentBillingStatusYes'=>$percentBillingStatusYes,

                    'countDeviceStatusActive'=>$countDeviceStatusActive,
                    'countDeviceStatusFree'=>$countDeviceStatusFree,
                    'countDeviceStatusIdle'=>$countDeviceStatusIdle,

                    'percentDeviceStatusActive'=>$percentDeviceStatusActive,
                    'percentDeviceStatusFree'=>$percentDeviceStatusFree,
                    'percentDeviceStatusIdle'=>$percentDeviceStatusIdle,

                    'percentBillingDispensationFree'=>$percentBillingDispensationFree,
                    'percentBillingDispensationIdle'=>$percentBillingDispensationIdle,

                    'linkDeviceActive'      => $linkDeviceActive,
                    'linkDeviceFree'        => $linkDeviceFree,
                    'linkDeviceIdle'        => $linkDeviceIdle,
                    'linkBillingYes'        => $linkBillingYes,
                    'linkBillingNo'         => $linkBillingNo
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Creates a Batch Validity.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBatch($id)
    {
        if(Yii::$app->user->can('create-validity')){
            $model          = $this->findModel($id);
            $model->counter = (empty($model->counter)) ? '0' : $model->counter;

            $validityDetailAttributes = ['validity_id','customer_id','title','device_status','billing_status',
                                            'date_due','amount','month_period','description',
                                            'created_at','updated_at','created_by','updated_by','verlock'];

            $data                       = [];
            $dataSaved                  = 0;
            $dataQueryLimit             = Yii::$app->params['Data_Query_Limit'];
            $dataEachLimit              = Yii::$app->params['Data_Each_Limit'];

            $billingStatusNo            = ValidityDetail::BILLING_STATUS_NO;
            $billingStatusNotAvailable  = ValidityDetail::BILLING_STATUS_NA;
            $deviceStatusActive         = ValidityDetail::DEVICE_STATUS_ACTIVE;

            //PILIH CUSTOMER ID YANG TIDAK DC PERMANENT
            $templateOutletExisted      = OutletDetail::getDistinctDevicesWithoutDC(Enrolment::ENROLMENT_TYPE_ANALOG);

            $countOutletExisted         = $templateOutletExisted->count();
            //SELECT * FROM tbl LIMIT 5,10;  # Retrieve rows 6-15
            $offsetOutletExisted        = $templateOutletExisted->limit($dataQueryLimit)->offset($model->counter);

            $transaction = \Yii::$app->db->beginTransaction();
            try {

                foreach ($offsetOutletExisted->each($dataEachLimit) as $outletDetailModel) {

                    $customerId             = $outletDetailModel['customer_id'];
                    $deviceStatus           = $outletDetailModel['device_status'];

                    if($customerId=='5688'){
                        $test = 'x';
                    }
                    
                    //PERIKSA AWAL AKTIF PELANGGAN DAN MASA TAGIHAN YANG DIBUAT
                    //TAGIHAN YANG DIBUAT HARUS SETELAH MASA AKTIF
                    $enrolment              = Enrolment::find()->where(['customer_id'=>$customerId])->one();
                    $currBillingDate        = (empty($enrolment)) ? '0' : Helper::formatBillingCycle($enrolment->billing_cycle,$model->title);

                    //TANGGAL MULAI TAGIHAN IURAN DIMULAI BERDASARKAN TANGGAL BERLAKU
                    $dateStartBilling       = Helper::getFirstDateBilling($enrolment->date_effective,$enrolment->billing_cycle);
                    $isExistValidityDetail  = ValidityDetail::find()->where([
                                                    'validity_id'=>$id,
                                                    'customer_id'=>$customerId,
                                                    'device_status'=>$deviceStatus
                                                ])->one();

                    if(empty($isExistValidityDetail) && ($currBillingDate >= $dateStartBilling) ){

                        $outletDetail   = OutletDetail::find()
                                            ->where(['customer_id'=>$customerId,
                                                    'device_status'=>$deviceStatus
                                            ]);

                        $sumMonthlyBill = $outletDetail
                                            ->asArray()
                                            ->sum('monthly_bill');

                        $billingStatus  = ($deviceStatus==$deviceStatusActive) ? $billingStatusNo : $billingStatusNotAvailable;
                        $amount         = $sumMonthlyBill;
                        $billingCycle   = Enrolment::getBillingCycle($customerId);
                        $monthPeriod    = $model->title;

                        $countValidty   = ValidityDetail::find()
                                            ->select('customer_id, device_status')
                                            ->where(['customer_id'=>$customerId,'device_status'=>$deviceStatus])
                                            ->asArray()->count();

                        $description    = $countValidty.' Bulan';

                        $data[]=[
                            'validity_id'       => $id,
                            'customer_id'       => $customerId,
                            'title'             => Counter::getSerialNumber(Counter::CODE_OF_VALIDITY_DETAIL),
                            'device_status'     => $deviceStatus,
                            'billing_status'    => $billingStatus,
                            'date_due'          => Helper::formatBillingCycle($billingCycle, $monthPeriod),
                            'amount'            => $amount,
                            'month_period'      => $monthPeriod,
                            'description'       => $description,
                            'created_at'        => time(),
                            'updated_at'        => time(),
                            'created_by'         => Yii::$app->user->id,
                            'updated_by'         => Yii::$app->user->id,
                            'verlock'           => 0,
                        ];

                        $dataSaved = $dataSaved + 1;
                    }

                }

                ////////////////////////////////////////////////////////////////
                //TAGIHAN BULANAN

                Yii::$app->db->createCommand()->batchInsert(ValidityDetail::tableName(), $validityDetailAttributes, $data)->execute();

                $model->counter     = (($model->counter + $dataQueryLimit) >= $countOutletExisted) ? $countOutletExisted : ($model->counter + $dataQueryLimit);
                $model->description = 'Verified '.$model->counter.' of '.$countOutletExisted.' outlets';
                $model->save();

                $transaction->commit();

                $sisaData = ($countOutletExisted-$model->counter);
                Yii::$app->getSession()->setFlash('success', [
                    'message' => Yii::t('app', Html::encode('Data validasi berhasil disimpan '.$dataSaved.' outlet. Sisa '.$sisaData.'.')),
                ]);

                return $this->redirect(['view','id'=>$id]);

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

    public function actionDeleteBatch($id){
        if(Yii::$app->user->can('delete-validity')){

            $model              = $this->findModel($id);

            //HANYA BOLEH DI-DELETE YANG BELUM DIBUATKAN BILLING NYA
            $validityDetails    = ValidityDetail::find()->where([
                                        'validity_id'=>$model->id,
                                        'billing_status'=> ValidityDetail::BILLING_STATUS_NO
                                    ]);

            $counterDelete      = 0;
            $dataEachLimit      = Yii::$app->params['Data_Each_Limit'];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($validityDetails->each($dataEachLimit) as $validityDetailModel) {
                    $validityDetailModel->delete();
                    $counterDelete = $counterDelete +1;
                }

                if(!empty($validityDetails)){
                    $model->counter     = 0;
                    $model->description = '-';
                    $model->save();
                }

                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'message' => Yii::t('app', Html::encode('Data validasi dihapus : '.$counterDelete)),
                ]);

                return $this->redirect(['view','id'=>$id]);
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
}
