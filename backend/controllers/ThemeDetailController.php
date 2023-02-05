<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; // load classes

use backend\models\Theme;
use backend\models\ThemeDetail;
use backend\models\ThemeDetailSearch;
use common\helper\Helper;
/**
 * ThemeDetailController implements the CRUD actions for ThemeDetail model.
 */
class ThemeDetailController extends Controller
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

    
    public function actions() {

        return [
            'browse-images' => [
                'class' => 'backend\editor\BrowseAction',
                'quality' => 100,
                'maxWidth' => 900,
                'maxHeight' => 900,
                'useHash' => true,
                'url' => '@web/uploads/theme/',
                'path' => '@backend/web/uploads/theme/',
            ],
            'upload-images' => [
                'class' => 'backend\editor\UploadAction',
                'quality' => 100,
                'maxWidth' => 900,
                'maxHeight' => 900,
                'useHash' => true,
                'url' => '@web/uploads/theme/',
                'path' => '@backend/web/uploads/theme/',
            ],
        ];
    }
    
    /**
     * Lists all ThemeDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-theme')){
            $searchModel = new ThemeDetailSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $dataList=ArrayHelper::map(Theme::find()->asArray()->all(), 'id','title');

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
     * Displays a single ThemeDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-theme')){
            $model = $this->findModel($id);
            $dataList=ArrayHelper::map(Theme::find()->asArray()->all(), 'id','title');

            $oldFile = $model->getImageFile();
            $oldAvatar = $model->file_name;
            $oldFileName = $model->title;         
            
            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();

                // revert back if no valid file instance uploaded
                if ($image === false) {
                    $model->file_name = $oldAvatar;
                    //$model->title = $oldFileName;
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
     * Creates a new ThemeDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-theme')){
            $model      = new ThemeDetail;            
            $dataList   = ArrayHelper::map(Theme::find()->asArray()->all(), 'id','title');
            
            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();    

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) {
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->id]);
                } else {
                    // error in saving model
                }
            }
            return $this->render('create', [
                'model'=>$model,
                'dataList'=>$dataList,
                'editor'=>false,
            ]);           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          
        
    }

    /**
     * Updates an existing ThemeDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$editor=false)
    {
        if(Yii::$app->user->can('update-theme')){
            $model = $this->findModel($id);
            $dataList=ArrayHelper::map(Theme::find()->asArray()->all(), 'id','title');

            $oldFile = $model->getImageFile();
            $oldAvatar = $model->content;
            $oldFileName = $model->title;

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();

                // revert back if no valid file instance uploaded
                if ($image === false) {
                    //$model->content = $oldAvatar;
                    //$model->title = $oldFileName;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->id]);
                } else {
                    // error in saving model
                }
            }
            return $this->render('update', [
                'model'=>$model,
                'editor'=>$editor,
                'dataList'=>$dataList
            ]);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           
                    
        
    }

    /**
     * Deletes an existing ThemeDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-theme')){
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
     * Deletes an existing ThemeDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteImage($id)
    {
        if(Yii::$app->user->can('delete-theme')){
            $model = $this->findModel($id);

            // validate deletion and on failure process any exception 
            // e.g. display an error message 
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
            else{
                $model->content = '';
                $model->save();
                Yii::$app->getSession()->setFlash('success', ['message' => 'Image removed']);
            }

            return $this->redirect(['view','id'=>$model->id]);          
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         

    }    
    
    /**
     * Finds the ThemeDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ThemeDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ThemeDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionStripTags($id){
        if(Yii::$app->user->can('update-theme')){

            $model = $this->findModel($id);
            $model->content = strip_tags($model->content);
            $model->save();
            
            return $this->redirect(['view', 'id'=>$model->id]);       
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          
    }
    
    public function actionHome()
    {
        if(Yii::$app->user->can('index-theme')){
            return $this->render(strtolower(Yii::$app->params['Theme_Active']).'/home', [

            ]);        
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

}
