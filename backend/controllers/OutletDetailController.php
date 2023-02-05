<?php

namespace backend\controllers;

use Yii;
use backend\models\OutletDetail;
use backend\models\OutletDetailSearch;
use backend\models\Lookup;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * OutletDetailController implements the CRUD actions for OutletDetail model.
 */
class OutletDetailController extends Controller
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
     * Lists all OutletDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        if(Yii::$app->user->can('index-outlet')){
            $searchModel = new OutletDetailSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $deviceTypeList     = OutletDetail::getArrayDeviceType();
            $deviceStatusList   = OutletDetail::getArrayDeviceStatus();
            
            return $this->render('index', [
                'dataProvider'      => $dataProvider,
                'searchModel'       => $searchModel,
                'deviceTypeList'    => $deviceTypeList,
                'deviceStatusList'  => $deviceStatusList
                    
            ]);           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          
        
    }

    /**
     * Displays a single OutletDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        if(Yii::$app->user->can('view-outlet')){
            $model = $this->findModel($id);

            $this->redirect(['outlet/view', 'id' => $model->outlet_id]);
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            } else {
//                return $this->render('view', ['model' => $model]);
//            }          
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
        

    }

    /**
     * Creates a new OutletDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-outlet')){
            $model = new OutletDetail;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }            
    }

    /**
     * Updates an existing OutletDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-outlet')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }               
    }

    /**
     * Deletes an existing OutletDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-outlet')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           
    }

    /**
     * Finds the OutletDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OutletDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OutletDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
