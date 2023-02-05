<?php

namespace backend\controllers;

use Yii;
use backend\models\Enrolment;
use backend\models\EnrolmentSearch;
use backend\models\Customer;
use backend\models\Network;
use backend\models\Outlet;
use backend\models\OutletDetail;
use backend\models\Counter;
use backend\models\Area;
use backend\models\Village;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * EnrolmentController implements the CRUD actions for Enrolment model.
 */
class EnrolmentController extends Controller
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
     * Lists all Enrolment models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('index-enrolment')) {
            $searchModel            = new EnrolmentSearch;
            $areaList               = ArrayHelper::map(Area::find()->asArray()->all(), 'id', 'title');
            $villageList            = ArrayHelper::map(Village::find()->asArray()->all(), 'id', 'title');
            $networkList            = Network::getArrayList();
            $enrolmentTypeList      = Enrolment::getArrayEnrolmentType();
            $dataProvider           = $searchModel->search(Yii::$app->request->getQueryParams());

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'networkList'=>$networkList,
                'areaList'=>$areaList,
                'villageList'=>$villageList,
                'enrolmentTypeList'=>$enrolmentTypeList,
                'billingCycleList'=>$this->billingCycleList,
            ]);
        } else {
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
        $searchModel        = new EnrolmentSearch;
        $networkList        = Network::getArrayList();
        $dataProvider       = $searchModel->search(Yii::$app->request->getQueryParams());

        $enrolmentTypeList  = Enrolment::getArrayEnrolmentType();
        //tidak ada attribute device_status
        //$dataProvider->query->where(['<>','device_status', Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusDisconnect'])]);

        return $this->render('select', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'networkList'=>$networkList,
            'module'=>$module, //MODULE YANG DIPILIH
            'billingCycleList'=>$this->billingCycleList,
            'enrolmentTypeList'=>$enrolmentTypeList
        ]);
    }

    /**
     * Displays a single Enrolment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $title=null)
    {
        if (Yii::$app->user->can('view-enrolment')) {
            $model                  = $this->findModel($id);
            $networkList            = Network::getArrayList();
            $enrolmentTypeList      = Enrolment::getArrayEnrolmentType();

            $customerList   = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id', 'title');

            $customer = Customer::find()->where(['id'=>$model->customer_id])->one();

            ////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////

            $providerValidityDetail = new ArrayDataProvider([
                    'allModels' => $customer->validityDetails,
                    'pagination' => [ 'pageSize' => 10 ],
                    'sort' => [
                        'attributes' => ['created_at'],
                        'defaultOrder' => ['created_at' => 'DESC']
                    ],
            ]);

            ////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////

            $tmpOutletDetailDeviceStatus   = OutletDetail::getDeviceByCustomer($model->customer_id);
            $outletDetailDeviceStatus       =OutletDetail::getOneDeviceStatus($tmpOutletDetailDeviceStatus);

            $providerOutletDetail = new ArrayDataProvider([
                'allModels' => $customer->outletDetails,
                'pagination' => false,
                'sort' => [
                    'attributes' => ['created_at'],
                    'defaultOrder' => ['created_at' => 'DESC']
                ],
            ]);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'customer'=>$customer,
                    'networkList'=>$networkList,
                    'enrolmentTypeList'=>$enrolmentTypeList,
                    'customerList'=>$customerList,
                    'billingCycleList'=>$this->billingCycleList,
                    'outletDetailDeviceStatus'=>$outletDetailDeviceStatus,
                    'providerValidityDetail'=>$providerValidityDetail,
                    'providerOutletDetail'=>$providerOutletDetail
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Enrolment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if (Yii::$app->user->can('create-enrolment')) {
            $model                  = new Enrolment;
            $model->customer_id     = $id;

            $networkTitleList   = Network::getArrayTitleList();
            $enrolmentTypeList  = Enrolment::getArrayEnrolmentType();
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id', 'title');
            $nextNumber         = Counter::getNextNumber(Counter::COUNTER_OF_ENROLMENT);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();

                return $this->render('create', [
                    'model' => $model,
                    'customer'=>$customer,
                    'networkTitleList' => $networkTitleList,
                    'enrolmentTypeList'=>$enrolmentTypeList,
                    'customerList' => $customerList,
                    'nextNumber'=>$nextNumber,
                    'billingCycleList'=>$this->billingCycleList,
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Enrolment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('update-enrolment')) {
            $model                      = $this->findModel($id);
            $model->network_tags_title  = Network::getTitle($model->network_id);
            $networkTitleList           = Network::getArrayTitleList();
            $enrolmentTypeList          = Enrolment::getArrayEnrolmentType();
            $customerList               = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id', 'title');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['customer/view', 'id' => $model->customer_id]);
            } else {

                ////////////////////////////////////////////////////////////////////
                //DATA UNTUK DITAMPILKAN DI BAGIAN SAMPING
                $customer = Customer::find()->where(['id'=>$model->customer_id])->one();

                return $this->render('update', [
                    'model' => $model,
                    'customer'=>$customer,
                    'networkTitleList'=>$networkTitleList,
                    'enrolmentTypeList'=>$enrolmentTypeList,
                    'customerList'=>$customerList,
                    'billingCycleList'=>$this->billingCycleList
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Enrolment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-enrolment')) {
            $model = $this->findModel($id);
            $outlet = Outlet::findOne(['customer_id'=>$model->customer_id]);

            if (!empty($outlet)) {
                Yii::$app->getSession()->setFlash('danger', [
                    'message' => Yii::t('app', 'Tidak bisa menghapus data setelah memiliki outlet.'),
                ]);
                return $this->redirect(['site/message']);
            } else {
                $model->deleteWithRelated();
                Yii::$app->getSession()->setFlash('success', [
                    'message' => Yii::t('app', 'Data berhasil dihapus'),
                ]);
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Enrolment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Enrolment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Enrolment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
