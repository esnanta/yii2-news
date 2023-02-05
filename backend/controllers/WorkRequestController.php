<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\base\Model;

use backend\models\WorkRequest;
use backend\models\WorkRequestSearch;
use backend\models\Staff;
use backend\models\Customer;
use backend\models\CustomerSearch;
use backend\models\Area;
use backend\models\Village;
/**
 * WorkRequestController implements the CRUD actions for WorkRequest model.
 */
class WorkRequestController extends Controller
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
     * Lists all WorkRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkRequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $staffList   = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');

        $providerWorkRequestDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->workRequestDetails,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'staffList' => $staffList,
            'providerWorkRequestDetail' => $providerWorkRequestDetail,
        ]);
    }

    /**
     * Creates a new WorkRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=null)//id = customer id
    {
        $model              = new WorkRequest();
        $staffList          = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');
        $model->date_issued = time();

        if(!empty($id)){
            $customer               = Customer::find()->where(['id'=>$id])->one();
            $model->customer_id     = $customer->id;
            $model->customer_title  = $customer->title;
            $model->phone_number    = $customer->phone_number;
            $model->address         = $customer->address;
        }

        if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->loadAll(Yii::$app->request->post()) && Model::validateMultiple([$model])) {

            foreach ($model->workRequestDetails as $detailModel) {
                if($detailModel->validate()==false){

                    Yii::$app->getSession()->setFlash('danger', [
                        'message' => Yii::t('app', Html::encode('Input detail harap diisi dengan benar.'))
                    ]);

                    return $this->render('create', [
                        'model' => $model,
                        'staffList' => $staffList,
                        'workRequestDetails'=>$model->workRequestDetails
                    ]);
                }
                else{
                    $detailModel->customer_id = $model->customer_id;
                }
            }


            $model->saveAll();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'staffList' => $staffList,
                'workRequestDetails'=>$model->workRequestDetails
            ]);
        }
    }

    /**
     * Updates an existing WorkRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $staffList   = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'staffList' => $staffList,
            ]);
        }
    }

    /**
     * Deletes an existing WorkRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }


    /**
     * Finds the WorkRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
    * Action to load a tabular form grid
    * for WorkRequestDetail
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddWorkRequestDetail()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('WorkRequestDetail');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formWorkRequestDetail', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

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

}
