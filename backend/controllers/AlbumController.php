<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

use backend\models\Album;
use backend\models\AlbumSearch;
use backend\models\Photo;

use common\helper\Helper;


/**
 * AlbumController implements the CRUD actions for Album model.
 */
class AlbumController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Album models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-album')){
            $searchModel = new AlbumSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $dataList=Album::getArrayAlbumType();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'dataList'=>$dataList
            ]);         
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           
    }

    /**
     * Displays a single Album model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-album')){
            $model = $this->findModel($id);
            $photos = Photo::find()->where(['album_id'=>$model->id])->orderBy(['created_at'=>SORT_DESC])->all();
            
            $dataList=Album::getArrayAlbumType();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,'dataList'=>$dataList,
                    'photos' => $photos
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }        
    }

    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-album')){
            $model = new Album;
            $dataList=Album::getArrayAlbumType();

            try {

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'dataList'=>$dataList
                    ]);
                }            

            } 
            catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-album')){
            $model = $this->findModel($id);
            $dataList=Album::getArrayAlbumType();

            try {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                        'dataList'=>$dataList
                    ]);
                }            
            } 
            catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-album')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);         
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           
    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Album::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionCover($id,$title=null){
        if(Yii::$app->user->can('create-album')){
            $photo = Photo::find()->where(['id'=>$id])->one();
            $model = Album::find()->where(['id'=>$photo->album_id])->one();
            try {

                //'https://'.Yii::$app->getRequest()->serverName.$photo->getImageUrl()
                $model->cover = $photo->getImageUrl();
 
                if ($model->save()) {
                    return $this->redirect(['view','id'=>$model->id]); 
                } 
                else {
                    throw new Exception('Error set as cover!');
                }            

            } 
            catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }             
            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }             
    }
        
    
    
    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        if(Yii::$app->user->can('delete-photo')){
            $photo = Photo::find()->where(['id'=>$id])->one();
            $album_id = $photo->album->id;
                    
            // validate deletion and on failure process any exception 
            // e.g. display an error message 
            if ($photo->delete()) {
                if (!$photo->deleteImage()) {
                    Yii::$app->session->setFlash('error', 'Error deleting image');
                }
            }
            return $this->redirect(['view','id'=>$album_id]);           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 
               
    }    
}
