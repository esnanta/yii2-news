<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; // load classes
use yii\helpers\FileHelper;

use common\models\User;
use common\models\Profile;
use common\models\AuthAssignment;

use common\helper\MessageHelper;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    
    public static $pathTmpCrop='/uploads/tmp';
    
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . self::$pathTmpCrop;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);      
        }
        
        return [
            'avatar' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => Yii::$app->urlManager->baseUrl.self::$pathTmpCrop,
                'path' => str_replace('frontend', 'backend', Yii::getAlias('@webroot')).self::$pathTmpCrop,
                //'name' => Yii::$app->security->generateRandomString(),   
                'width'=> '400',
                'height'=> '400' ,    
                'maxSize'=> 4097152,  
            ]
        ];
    }       
    
    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-profile')){
            return $this->redirect(['view','id'=>Yii::$app->user->id,'name'=>Yii::$app->user->identity]);       
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        } 
        
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-profile')){
            $model = $this->findModel($id);
            $dataList = ArrayHelper::map(User::find()->asArray()->all(), 'id','username');

            $authAssignments = AuthAssignment::find()->where(['user_id'=>Yii::$app->user->id])->all();
            
            $oldFile = $model->getImageFile();
            $oldAvatar = $model->file_name;
            
            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();

                // revert back if no valid file instance uploaded
                if ($image === false) {
                    $model->file_name = $oldAvatar;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->user_id]);
                } else {
                    // error in saving model
                }
            }        
            else {
                return $this->render('view', [
                    'model' => $model,
                    'dataList'=>$dataList,
                    'authAssignments'=>$authAssignments
                ]);
            }            
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }  
              
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-profile')){
            $model = new Profile;
            $dataList=ArrayHelper::map(User::find()->asArray()->all(), 'id','username');

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $image = $model->uploadImage();    

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false) {
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->user_id]);
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
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }  
          
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-profile')){
            $model = $this->findModel($id);
            if(Yii::$app->user->identity->isAdmin==false){
                $model = Profile::find()->where(['user_id'=>Yii::$app->user->id])->one();
            }

            $oldFile = $model->getImageFile();

            if ($model->load(Yii::$app->request->post())) {

                $urlTmpCrop = Yii::$app->urlManager->baseUrl.self::$pathTmpCrop;
                $model->file_name = str_replace($urlTmpCrop, '', $model->file_name);
                $model->file_name = str_replace('/', '', $model->file_name);       
                
                if ($model->save()) {
                    //DELETE FILE LAMA
                    file_exists($urlTmpCrop.'/'.$model->file_name) ? unlink($urlTmpCrop.'/'.$model->file_name) : '' ;
                    //PINDAHIN DATA DARI TMP KE DIREKTORI MODEL
                    rename(str_replace('frontend', 'backend', Yii::getAlias('@webroot')).self::$pathTmpCrop.'/'.$model->file_name, $model->getImageFile());
                    return $this->redirect(['view', 'id'=>$model->id, 'title'=>$model->title]);
                }
                
                else {
                    // error in saving model
                }
            }
            return $this->render('update', [
                'model'=>$model,
            ]);            
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        } 
           
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        MessageHelper::getFlashAccessDenied();
        throw new ForbiddenHttpException;        
        
//        if(Yii::$app->user->can('delete-profile')){
//            $model = $this->findModel($id);
//
//            // validate deletion and on failure process any exception 
//            // e.g. display an error message 
//            if ($model->delete()) {
//                if (!$model->deleteImage()) {
//                    Yii::$app->session->setFlash('error', 'Error deleting image');
//                }
//            }
//            return $this->redirect(['index']);          
//        }
//        else{
//            MessageHelper::getFlashAccessDenied();
//            throw new ForbiddenHttpException;
//        } 
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

