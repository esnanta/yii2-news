<?php

namespace backend\controllers;

use Yii;
use backend\models\Album;
use backend\models\Photo;
use backend\models\PhotoSearch;
use common\helper\Helper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
 //
/**
 * PhotoController implements the CRUD actions for Photo model.
 */

class PhotoController extends Controller
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
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-photo')){
            $searchModel = new PhotoSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $dataList=ArrayHelper::map(Album::find()->asArray()->all(), 'id','title');

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
     * Displays a single Photo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-photo')){
            $model = $this->findModel($id);
            $dataList=ArrayHelper::map(Album::find()->asArray()->all(), 'id','title');

            $oldFile = $model->getImageFile();
            $oldAvatar = $model->file_name;
            $oldFileName = $model->title;

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();

                // revert back if no valid file instance uploaded
                if ($image === false) {
                    $model->file_name = $oldAvatar;
                    $model->title = $oldFileName;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->id]);
                } 
                else {
                    // error in saving model
                }
            }        
            else {
                return $this->render('view', [
                    'model' => $model,
                    'dataList'=>$dataList
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 
        
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if(Yii::$app->user->can('create-photo')){
            $model = new Photo;
            $model->album_id = $id;
            $dataList=ArrayHelper::map(Album::find()->asArray()->all(), 'id','title');

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();    

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) {
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['album/view', 'id'=>$model->album_id]);
                } else {
                    // error in saving model
                }
            }
            return $this->render('create', [
                'model'=>$model,
                'dataList'=>$dataList
            ]);             
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
 
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-photo')){
            $model = $this->findModel($id);
            $dataList=ArrayHelper::map(Album::find()->asArray()->all(), 'id','title');

            $oldFile = $model->getImageFile();
            $oldAvatar = $model->file_name;
            $oldFileName = $model->title;

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();

                // revert back if no valid file instance uploaded
                if ($image === false) {
                    $model->file_name = $oldAvatar;
                    $model->title = $oldFileName;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['album/view', 'id'=>$model->album_id]);
                } else {
                    // error in saving model
                }
            }
            return $this->render('update', [
                'model'=>$model,
                'dataList'=>$dataList
            ]);            
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
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-photo')){
            $model = $this->findModel($id);

            // validate deletion and on failure process any exception 
            // e.g. display an error message 
            if ($model->delete()) {
                if (!$model->deleteImage()) {
                    Yii::$app->session->setFlash('error', 'Error deleting image');
                }
            }
            return $this->redirect(['index']);           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 
               
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
