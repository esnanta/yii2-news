<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use backend\models\Area;
use backend\models\Billing;
use backend\models\BillingPeriod;
use backend\models\BillingSearch;
use backend\models\Outlet;
use backend\models\ValidityDetail;
use backend\models\Receivable;
use backend\models\ReceivableDetail;
use backend\models\Customer;
use backend\models\Enrolment;
use backend\models\Counter;

use common\helper\Helper;

/**
 * BillingController implements the CRUD actions for Billing model.
 */
class BillingController extends Controller
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
     * Lists all Billing models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-billing')){
            $searchModel = new BillingSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $areaList           = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $billingTypeList    = Billing::getArrayBillingType();
            $paymentStatusList  = Billing::getArrayPaymentStatus();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'areaList' => $areaList,
                'billingTypeList'=>$billingTypeList,
                'paymentStatusList'=>$paymentStatusList
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionSelect($module)//MODULE YANG DIPILIH
    {

        $searchModel    = new BillingSearch;

        $billingTypeList    = Billing::getArrayBillingType();
        $paymentStatusList  = Billing::getArrayPaymentStatus();

        $dataProvider   = $searchModel->search(Yii::$app->request->getQueryParams());
        //$dataProvider->query->andWhere(['payment_status'=> Billing::PAYMENT_STATUS_CREDIT]);
        //$dataProvider->query->orWhere(['payment_status'=> Billing::PAYMENT_STATUS_INSTALLMENT]);

        return $this->render('select', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'billingTypeList'=>$billingTypeList,
            'paymentStatusList'=>$paymentStatusList,
            'module'=>$module, //MODULE YANG DIPILIH
        ]);

    }

    /**
     * Displays a single Billing model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-billing')){
            $model = $this->findModel($id);
            $areaList           = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $billingTypeList    = Billing::getArrayBillingType();
            $paymentStatusList  = Billing::getArrayPaymentStatus();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
                $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN BAWAH

                $receivableDetail   = ReceivableDetail::find()->where(['billing_id'=>$id])->one();
                $receivable         = null;
                $providerReceivableDetail = null;

                if(!empty($receivableDetail)){
                    $receivable = Receivable::find()->where(['id'=>$receivableDetail->receivable_id])->one();

                    $providerReceivableDetail = new ArrayDataProvider([
                        'allModels' => $receivable->receivableDetails,
                        'pagination' => false,
                        'sort' => [
                            'attributes' => ['created_at'],
                            'defaultOrder' => ['created_at' => 'DESC']
                        ],
                    ]);
                }


                return $this->render('view', [
                    'model'                     => $model,
                    'areaList'                  => $areaList,
                    'billingTypeList'           => $billingTypeList,
                    'paymentStatusList'         => $paymentStatusList,
                    'customer'                  => $customer,
                    'enrolment'                 => $enrolment,
                    'receivable'               => $receivable,
                    'providerReceivableDetail'  => $providerReceivableDetail
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Creates a new Billing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if(Yii::$app->user->can('create-billing')){

            $model                      = new BillingPeriod;
            $model->customer_id         = $id;

            $model->billing_type        = Billing::TYPE_IURAN;
            $model->payment_status      = Billing::PAYMENT_STATUS_CREDIT;
            $billingStatusNo            = ValidityDetail::BILLING_STATUS_NO;
            $billingStatusYes           = ValidityDetail::BILLING_STATUS_YES;


            $model->date_issued     = time();

            $validityDetailList = ArrayHelper::map(
                    ValidityDetail::find()
                        ->select('id,month_period,amount')
                        ->asArray()
                        ->where(['customer_id'=>$id,'billing_status'=>$billingStatusNo])
                        ->all(), 'id', 'month_period', 'amount');

            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $billingTypeList    = Billing::getArrayBillingType();
            $paymentStatusList  = Billing::getArrayPaymentStatus();

            ////////////////////////////////////////////////////////////////////
            //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
            $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
            $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();

            if ($model->load(Yii::$app->request->post())) {

                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    foreach ($model->validity_period as $i=>$validityId) {

                        $validityDetail             = ValidityDetail::find()->where(['id'=>$validityId])->one();
                        $invoice                    = $validityDetail->title;
                        $amount                     = $validityDetail->amount;
                        $dateDue                    = $validityDetail->date_due;
                        $monthPeriod                = $validityDetail->month_period;

                        $billing                    = new Billing;
                        $billing->customer_id       = $id;
                        $billing->title             = Counter::getSerialNumber(Counter::CODE_OF_BILLING);
                        $billing->invoice           = $invoice;
                        $billing->amount            = $amount;
                        $billing->date_issued       = $model->date_issued;
                        $billing->date_due          = $dateDue;
                        $billing->month_period      = $monthPeriod;
                        $billing->billing_type      = $model->billing_type; //BILLING TYPE MONTHLY
                        $billing->payment_status    = $model->payment_status;
                        $billing->description       = $model->description;
                        $billing->save();

                        $validityDetail->billing_status = $billingStatusYes;
                        $validityDetail->save();

                    }

                    $transaction->commit();
                    return $this->redirect(['/enrolment/view', 'id' => $enrolment->id]); //id = customer id

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

                return $this->render('create', [
                    'model'                 => $model,
                    'validityDetailList'    => $validityDetailList,
                    'customerList'          => $customerList,
                    'billingTypeList'       => $billingTypeList,
                    'paymentStatusList'     => $paymentStatusList,
                    'customer'              => $customer,
                    'enrolment'             => $enrolment,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    public function actionOutlet($id){
        if(Yii::$app->user->can('create-billing')){

            $outlet = Outlet::find()->where(['id'=>$id])->one();

            $billingStatusYes = ValidityDetail::BILLING_STATUS_YES;
            $paymentStatusCredit            = Billing::PAYMENT_STATUS_CREDIT;

            $transaction = \Yii::$app->db->beginTransaction();

            try {

                $model                    = new Billing;
                $model->customer_id       = $outlet->customer_id;
                $model->title             = Counter::getSerialNumber(Counter::CODE_OF_BILLING);
                $model->invoice           = $outlet->title;
                $model->amount            = $outlet->claim;
                $model->date_issued       = time();
                $model->date_due          = Helper::getDue($outlet->date_assembly);
                $model->month_period      = $outlet->month_period;
                $model->billing_type      = $outlet->getBillingTypeFromAssembly();
                $model->payment_status    = $paymentStatusCredit;
                $model->description       = $outlet->description;
                $model->save();

                $outlet->billing_status   = $billingStatusYes;
                $outlet->save();

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
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Billing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-billing')){
            $model = $this->findModel($id);
            $billingTypeList    = Billing::getArrayBillingType();
            $paymentStatusList  = Billing::getArrayPaymentStatus();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'billingTypeList'=>$billingTypeList,
                    'paymentStatusList'=>$paymentStatusList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Deletes an existing Billing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-billing')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Finds the Billing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Billing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Billing::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Billing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReview($month)
    {

        $billingStatusNo      = ValidityDetail::BILLING_STATUS_NO;
        $validityDetailDeviceStatusActive   = ValidityDetail::DEVICE_STATUS_ACTIVE;
        $outletBillingStatusNo              = Outlet::BILLING_STATUS_NO;

        $outletQuery = Outlet::find()->where(['billing_status' => $outletBillingStatusNo])
                ->andWhere(['month_period'=>$month]);
                //->andWhere(['>', 'claim', '0']);

        $outletProvider = new ActiveDataProvider([
            'query' => $outletQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ],
        ]);

        $sumClaimOutlet = ($outletQuery->sum('claim') <> null) ? $outletQuery->sum('claim'):0;

        $validityDetailQuery = ValidityDetail::find()
                ->where(['device_status' => $validityDetailDeviceStatusActive])
                ->andWhere(['billing_status' => $billingStatusNo])
                ->andWhere(['month_period'=>$month]);
                //->andWhere(['>', 'amount', '0']);

        $validityDetailProvider = new ActiveDataProvider([
            'query' => $validityDetailQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ],
        ]);

        $sumAmountValidityDetail = ($validityDetailQuery->sum('amount') <> null) ? $validityDetailQuery->sum('amount'):0;

        $formatter = \Yii::$app->formatter;
        $totalClaim = $formatter->asDecimal($sumClaimOutlet + $sumAmountValidityDetail);

        return $this->render('review', [
            'month'=>$month,
            'outletProvider' => $outletProvider,
            'validityDetailProvider'=>$validityDetailProvider,
            'totalClaim'=>$totalClaim,
        ]);
    }

    /**
     * Creates a new Billing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBatch($month)
    {
        if(Yii::$app->user->can('create-billing')){

            $billingAttributes = ['customer_id','area_id','title','invoice','amount','date_issued','date_due',
                                    'month_period','billing_type','payment_status','description',
                                    'created_at','updated_at','created_by','updated_by','verlock'];

            $data                   = [];
            $dataCounter            = 0;

            $dataQueryLimit         = Yii::$app->params['Data_Query_Limit'];
            $dataEachLimit          = Yii::$app->params['Data_Each_Limit'];

            $billingStatusNo        = ValidityDetail::BILLING_STATUS_NO;
            $billingStatusYes       = ValidityDetail::BILLING_STATUS_YES;
            $deviceStatusActive     = ValidityDetail::DEVICE_STATUS_ACTIVE;

            $paymentStatusCredit    = Billing::PAYMENT_STATUS_CREDIT;
            $billingTypeMonthly     = Billing::TYPE_IURAN;

            $outletBillingStatusYes = Outlet::BILLING_STATUS_YES;

            $transaction = \Yii::$app->db->beginTransaction();
            try {

                ////////////////////////////////////////////////////////////////////
                //TAGIHAN INSTALASI
                $outlets   = Outlet::find()->where([
                    'billing_status'    => Outlet::BILLING_STATUS_NO,
                    'month_period'      => $month
                ])
                ->andWhere(['>', 'claim', '0'])
                ->limit($dataQueryLimit);

                $totalPasang    = $outlets->count();
                $sisaData       = 0;

                foreach ($outlets->each($dataEachLimit) as $outletModel) {

                    $billingType            = $outletModel->getBillingTypeFromAssembly();

                    $data[]=[
                        'customer_id'       => $outletModel->customer_id,
                        'area_id'           => $outletModel->customer->area_id,
                        'title'             => Counter::getSerialNumber(Counter::CODE_OF_BILLING),
                        'invoice'           => $outletModel->title,
                        'amount'            => $outletModel->claim,
                        'date_issued'       => time(),
                        'date_due'          => Helper::getDue($outletModel->date_issued),
                        'month_period'      => Helper::getMonthPeriod(time()),
                        'billing_type'      => $billingType, //BILLING TYPE DEVICE ASSEMBLY
                        'payment_status'    => $paymentStatusCredit, //CREDIT PAYMENT
                        'description'       => '',
                        'created_at'        => time(),
                        'updated_at'        => time(),
                        'created_by'         => Yii::$app->user->id,
                        'updated_by'         => Yii::$app->user->id,
                        'verlock'           => 0,
                    ];
                    $outletModel->billing_status = $outletBillingStatusYes;
                    $outletModel->save();

                    $dataCounter = $dataCounter + 1;
                    if($dataCounter==$dataQueryLimit){
                        $sisaData   = (($totalPasang-$dataCounter) <= 0) ? 0 : ($totalPasang-$dataCounter);
                    }
                }

                ////////////////////////////////////////////////////////////////////
                //TAGIHAN BULANAN
                $validityDetails = ValidityDetail::find()
                        ->where(['device_status'        => $deviceStatusActive])
                        ->andWhere(['billing_status'    => $billingStatusNo])
                        ->andWhere(['month_period'      => $month])
                        ->andWhere(['>', 'amount', '0'])
                        ->limit($dataQueryLimit);

                $totalIuran = $validityDetails->count();
                $totalData  = ($totalPasang + $totalIuran);

                foreach ($validityDetails->each($dataEachLimit) as $validityDetailModel) {

                    $data[]=[
                        'customer_id'       => $validityDetailModel->customer_id,
                        'area_id'           => $validityDetailModel->customer->area_id,
                        'title'             => Counter::getSerialNumber(Counter::CODE_OF_BILLING),
                        'invoice'           => $validityDetailModel->title,
                        'amount'            => $validityDetailModel->amount,
                        'date_issued'       => time(),
                        'date_due'          => $validityDetailModel->date_due,
                        'month_period'      => $validityDetailModel->month_period,
                        'billing_type'      => $billingTypeMonthly, //BILLING TYPE MONTHLY
                        'payment_status'    => $paymentStatusCredit, //CREDIT PAYMENT
                        'description'       => $validityDetailModel->description,
                        'created_at'       => time(),
                        'updated_at'       => time(),
                        'created_by'         => Yii::$app->user->id,
                        'updated_by'         => Yii::$app->user->id,
                        'verlock'           => 0,
                    ];

                    $validityDetailModel->billing_status = $billingStatusYes;
                    $validityDetailModel->save();

                    $dataCounter = $dataCounter + 1;
                    if($dataCounter==$dataQueryLimit){
                        $sisaData   = (($totalData-$dataCounter) <= 0) ? 0 : ($totalData-$dataCounter);
                    }
                }

                //print_r($data);
                //die();

                Yii::$app->db->createCommand()->batchInsert(Billing::tableName(), $billingAttributes, $data)->execute();
                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'message' => Yii::t('app', Html::encode('Data berhasil disimpan. ('.$dataCounter.' records).')),
                ]);

                return $this->redirect(['review','month'=>$month]);

            } catch (\Exception $e) {
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
}
