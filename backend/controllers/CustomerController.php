<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use backend\models\Customer;
use backend\models\CustomerSearch;
use backend\models\Area;
use backend\models\Village;
use backend\models\Counter;
use backend\models\Enrolment;
use backend\models\Billing;
use backend\models\Receivable;
use backend\models\ReceivableDetail;

use common\helper\Helper;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-customer')){
            $searchModel    = new CustomerSearch;
            $areaList       = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $villageList    = ArrayHelper::map(Village::find()->asArray()->all(), 'id','title');
            $genderList     = Customer::getArrayModule();

            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'areaList'=>$areaList,
                'villageList'=>$villageList,
                'genderList'=>$genderList,
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

        $searchModel    = new CustomerSearch;

        $areaList       = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
        $villageList    = ArrayHelper::map(Village::find()->asArray()->all(), 'id','title');

        $dataProvider   = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('select', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'areaList' => $areaList,
            'villageList'=>$villageList,
            'module' => $module, //MODULE YANG DIPILIH
        ]);

    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-customer')){
            $model          = $this->findModel($id);

            //TAGIHAN PERTAMA PASANG BARU TIDAK ADA DALAM VALIDITY
            //TAPI PERLU DITAMPILKAN.
            //$billingAssemblys->all() dan $billingAssemblys->count() ada di view
            $billingAssemblys = Billing::find()->where(['customer_id'=>$model->id])
                                    ->andWhere(['<>', 'billing_type', Billing::TYPE_IURAN])
                                    ->orderBy(['created_at'=>SORT_ASC]);

            $providerValidityDetail = new ArrayDataProvider([
                    'allModels' => $model->validityDetails,
                    'pagination' => [ 'pageSize' => 10 ],
                    'sort' => [
                        'attributes' => ['created_at'],
                        'defaultOrder' => ['created_at' => 'DESC']
                    ],
            ]);

            $providerOutletDetail = new ArrayDataProvider([
                'allModels' => $model->outletDetails,
                'pagination' => [ 'pageSize' => 5 ],
                'sort' => [
                    'attributes' => ['created_at'],
                    'defaultOrder' => ['created_at' => 'DESC']
                ],
            ]);

            ////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////

            $villageList    = ArrayHelper::map(Village::find()->asArray()->all(), 'id','title');
            $areaList       = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $genderList     = Customer::getArrayModule();

            $enrolment      = Enrolment::find()->where(['customer_id'=>$model->id])->one();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'enrolment' => $enrolment,
                    'providerValidityDetail' => $providerValidityDetail,
                    'billingAssemblys' => $billingAssemblys,
                    'providerOutletDetail' => $providerOutletDetail,

                    'villageList'=>$villageList,
                    'areaList'=>$areaList,
                    'genderList'=>$genderList,

                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-customer')){
            $model          = new Customer;
            $villageList    = ArrayHelper::map(Village::find()->asArray()->all(), 'id','title');
            $areaList       = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $genderList     = Customer::getArrayModule();
            $nextNumber     = Counter::getNextNumber(Counter::COUNTER_OF_CUSTOMER);

            $model->date_issued = time();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'areaList'=>$areaList,
                    'genderList'=>$genderList,
                    'nextNumber'=>$nextNumber,
                    'villageList'=>$villageList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-customer')){
            $model = $this->findModel($id);
            $villageList    = ArrayHelper::map(Village::find()->asArray()->all(), 'id','title');
            $areaList       = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $genderList     = Customer::getArrayModule();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'areaList'=>$areaList,
                    'genderList'=>$genderList,
                    'villageList'=>$villageList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }

    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-customer')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
