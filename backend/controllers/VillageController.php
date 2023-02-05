<?php

namespace backend\controllers;

use Yii;
use backend\models\Village;
use backend\models\VillageSearch;
use backend\models\Area;
use common\helper\Helper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
/**
 * VillageController implements the CRUD actions for Village model.
 */
class VillageController extends Controller
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
     * Lists all Village models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-village')){
            $searchModel = new VillageSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'areaList'=>$areaList
            ]);          
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }   
        
    }

    /**
     * Displays a single Village model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-village')){
            $model = $this->findModel($id);
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'areaList'=>$areaList
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 

    }

    /**
     * Creates a new Village model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-village')){
            $model = new Village;
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'areaList'=>$areaList
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
        
    }

    /**
     * Updates an existing Village model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-village')){
            $model = $this->findModel($id);
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'areaList'=>$areaList
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 
        
    }

    /**
     * Deletes an existing Village model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-village')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Village model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Village the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Village::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
