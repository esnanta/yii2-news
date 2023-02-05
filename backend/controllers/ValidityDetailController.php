<?php

namespace backend\controllers;

use Yii;
use backend\models\ValidityDetail;
use backend\models\ValidityDetailPeriod;
use backend\models\ValidityDetailSearch;
use backend\models\Validity;
use backend\models\Customer;
use backend\models\OutletDetail;
use backend\models\Enrolment;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ValidityDetailController implements the CRUD actions for ValidityDetail model.
 */

class ValidityDetailController extends Controller
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
     * Lists all ValidityDetail models.
     * @return mixed
     */
    public function actionIndex($validityId=null)
    {
        if(Yii::$app->user->can('index-validity-detail')){
            $searchModel = new ValidityDetailSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $validityList       = ArrayHelper::map(Validity::find()->asArray()->where(['id'=>$validityId])->all(), 'id','title');
            $deviceStatusList   = ValidityDetail::getArrayDeviceStatus();
            $billingStatusList  = ValidityDetail::getArrayBillingStatus();

            return $this->render('index', [
                'dataProvider'      => $dataProvider,
                'searchModel'       => $searchModel,
                'validityList'      => $validityList,
                'deviceStatusList'  => $deviceStatusList,
                'billingStatusList' => $billingStatusList,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single ValidityDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-validity-detail')){
            $model              = $this->findModel($id);

            $formatter          = Yii::$app->formatter;
            $model->amount      = $formatter->asDecimal($model->amount);

            $validityList       = ArrayHelper::map(Validity::find()->asArray()->all(), 'id','title');
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $deviceStatusList   = ValidityDetail::getArrayDeviceStatus();
            $billingStatusList  = ValidityDetail::getArrayBillingStatus();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
                $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();

                return $this->render('view', [
                    'model' => $model,
                    'validityList'      => $validityList,
                    'customerList'      => $customerList,
                    'deviceStatusList'  => $deviceStatusList,
                    'billingStatusList' => $billingStatusList,
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

    /**
     * Creates a new ValidityDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    //$id = customer_id
    public function actionCreate($id,$title=null)
    {
        if(Yii::$app->user->can('create-validity-detail')){
            ////////////////////////////////////////////////////////////////////
            $model                  = new ValidityDetailPeriod;//PENTING////////
            $customer               = Customer::find()->where(['id'=>$id])->one();
            $enrolment              = Enrolment::find()->where(['customer_id'=>$id])->one();
            ////////////////////////////////////////////////////////////////////

            $model->customer_id     = $id;
            $model->device_status   = OutletDetail::getDeviceByCustomer($id);
            $model->amount          = $customer->sumMonthlyBill();

            $createdValidityDetails = ValidityDetail::find()->where(['customer_id'=>$id])->all();

            //JIKA STATUS AKTIV MAKA BILLING STATUS NO
            //JIKA STATUS SELAIN AKTIV, MAKA TIDAK DIBUAT BILLING / NA
            $model->billing_status  =
                    ($model->device_status==ValidityDetail::DEVICE_STATUS_ACTIVE) ?
                                        ValidityDetail::BILLING_STATUS_NO :
                                        ValidityDetail::BILLING_STATUS_NA;

            $formatter          = Yii::$app->formatter;
            $model->amount      = $formatter->asDecimal($model->amount);

            $validityList       = ArrayHelper::map(Validity::getUnsavedValidity($id), 'id','title');
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$id])->asArray()->all(), 'id','title');
            $deviceStatusList   = ValidityDetail::getArrayDeviceStatus();
            $billingStatusList  = ValidityDetail::getArrayBillingStatus();

            if ($model->load(Yii::$app->request->post())) {

                //PERIKSA AWAL AKTIF PELANGGAN DAN MASA TAGIHAN YANG DIBUAT
                //TAGIHAN YANG DIBUAT HARUS SETELAH MASA AKTIF

                $dateEffective      = (empty($enrolment)) ? '1':$enrolment->date_effective;

                foreach ($model->validity_period as $i=>$validityId) {

                    $checkValidityDetail    = ValidityDetail::find()->where([
                                                    'validity_id'=>$validityId,
                                                    'customer_id'=>$id
                                                ])->one();

                    $validity               = Validity::find()->where(['id'=>$validityId])->one();
                    $currBillingDate        = Helper::formatBillingCycle($enrolment->billing_cycle,$validity->title);
                    $dateDue                = $currBillingDate;

                    if(empty($checkValidityDetail) && $currBillingDate > $dateEffective){
                        $validityDetail                 = new ValidityDetail;
                        $validityDetail->validity_id    = $validity->id;
                        $validityDetail->customer_id    = $model->customer_id;
                        $validityDetail->device_status  = $model->device_status;
                        $validityDetail->billing_status = $model->billing_status;
                        $validityDetail->date_due       = $model->date_due;
                        $validityDetail->amount         = Helper::removeNumberSeparator($model->amount);
                        $validityDetail->month_period   = $validity->title;
                        $validityDetail->description    = $model->description;
                        $validityDetail->save();
                    }
                }

                return $this->redirect(['enrolment/view', 'id' => $enrolment->id]);

            }
            else {
                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING

                return $this->render('create', [
                    'model'                     => $model,
                    'createdValidityDetails'    => $createdValidityDetails,
                    'validityList'              => $validityList,
                    'customerList'              => $customerList,
                    'deviceStatusList'          => $deviceStatusList,
                    'billingStatusList'         => $billingStatusList,
                    'customer'                  => $customer,
                    'enrolment'                 => $enrolment,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Updates an existing ValidityDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-validity-detail')){
            $model              = $this->findModel($id);

            $formatter          = \Yii::$app->formatter;
            $model->amount      = $formatter->asDecimal($model->amount);

            $validityList       = ArrayHelper::map(Validity::find()->asArray()->all(), 'id','title');
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');
            $deviceStatusList   = ValidityDetail::getArrayDeviceStatus();
            $billingStatusList  = ValidityDetail::getArrayBillingStatus();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();
                $enrolment = Enrolment::find()->where(['customer_id'=>$model->customer_id])->one();

                return $this->render('update', [
                    'model' => $model,
                    'validityList'      => $validityList,
                    'customerList'      => $customerList,
                    'deviceStatusList'  => $deviceStatusList,
                    'billingStatusList' => $billingStatusList,
                    'customer'                  => $customer,
                    'enrolment'                 => $enrolment,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Deletes an existing ValidityDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-validity-detail')){
            $model      = $this->findModel($id);
            $validityId = $model->validity_id;
            $model->delete();

            return $this->redirect(['/validity/view','id'=>$validityId]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Finds the ValidityDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ValidityDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ValidityDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
