<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

use backend\models\Author;
use backend\models\AuthorSearch;

use backend\models\Blog;
use backend\models\Category;
use backend\models\BlogSearch;

use common\helper\Helper;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    
    public static $pathTmpCrop='/uploads/tmp';
    
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
                'path' => Yii::getAlias('@webroot').self::$pathTmpCrop,
                //'name' => Yii::$app->security->generateRandomString(),   
                'width'=> '400',
                'height'=> '400' ,    
                'maxSize'=> 4097152,  
            ]
        ];
    }    
    
    /**
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        if(Yii::$app->user->can('index-author')){
            $searchModel = new AuthorSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);         
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           
        
    }

    /**
     * Displays a single Author model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-author')){
            $model = $this->findModel($id);

            $searchModel = new BlogSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $dataProvider->query->andWhere(['author_id'=> $model->id]);

            $categoryList   =ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');
            $publishList    =Blog::getArrayPublishStatus();
            $pinnedList     =Blog::getArrayPinnedStatus();             

            if ($model->load(Yii::$app->request->post())) {

                if ($model->save()) {
                    return $this->redirect(['view', 'id'=>$model->id]);
                } else {
                    // error in saving model
                }
            }        
            else {
                return $this->render('view', [
                    'model' => $model,
                    'dataProvider'  => $dataProvider,
                    'searchModel'   => $searchModel,
                    'categoryList'  => $categoryList,
                    'publishList'   => $publishList,
                    'pinnedList'    => $pinnedList,                 
                    
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-author')){
            $model          = new Author;

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
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-author')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {

                $urlTmpCrop = Yii::$app->urlManager->baseUrl.self::$pathTmpCrop;
                $model->file_name = str_replace($urlTmpCrop, '', $model->file_name);
                $model->file_name = str_replace('/', '', $model->file_name);      
                
                if ($model->save()) {
                    //DELETE FILE LAMA
                    file_exists($urlTmpCrop.'/'.$model->file_name) ? unlink($urlTmpCrop.'/'.$model->file_name) : '' ;
                    //PINDAHIN DATA DARI TMP KE DIREKTORI MODEL
                    rename(Yii::getAlias('@webroot').self::$pathTmpCrop.'/'.$model->file_name, $model->getImageFile());
                    return $this->redirect(['view', 'id'=>$model->id]);
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
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-author')){
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
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
