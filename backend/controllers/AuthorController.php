<?php

namespace backend\controllers;

use common\helper\MediaTypeHelper;
use common\helper\MessageHelper;
use common\models\Article;
use common\models\ArticleSearch;
use common\models\Author;
use common\models\AuthorMediaSearch;
use common\models\AuthorSearch;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    
    public static $pathTmpCrop='/uploads/tmp';
    
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'delete-file' => ['post'],
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
     * @throws ForbiddenHttpException
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
            MessageHelper::getFlashAccessDenied();
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
            $model      = $this->findModel($id);
            $mediaType  = MediaTypeHelper::getSocial();

            $searchModelArticle = new ArticleSearch();
            $dataProvider = $searchModelArticle->search(Yii::$app->request->getQueryParams());
            $dataProvider->query->andWhere(['author_id'=> $model->id]);

            $searchModelMedia = new AuthorMediaSearch();
            $dataProviderSocial = $searchModelMedia->search(Yii::$app->request->getQueryParams());
            $dataProviderSocial->query->andWhere(['media_type' => $mediaType]);
            
            $officeList         = DataListService::getOffice();
            $articleCategory    = DataListService::getArticleCategory();
            $publishList        = Article::getArrayPublishStatus();
            $pinnedList         = Article::getArrayPinnedStatus();

            if ($model->load(Yii::$app->request->post())) {

                if ($model->save()) {
                    MessageHelper::getFlashSaveSuccess();
                    return $this->redirect(['view', 'id'=>$model->id]);
                } else {
                    MessageHelper::getFlashSaveFailed();
                }
            }        
            else {
                return $this->render('view', [
                    'model' => $model,
                    'dataProvider'  => $dataProvider,
                    'dataProviderSocial' => $dataProviderSocial,
                    'searchModelArticle'   => $searchModelArticle,
                    'officeList'    => $officeList,
                    'categoryList'  => $articleCategory,
                    'publishList'   => $publishList,
                    'pinnedList'    => $pinnedList,
                    'mediaType'     => $mediaType
                    
                ]);
            }           
        }
        else{
            MessageHelper::getFlashAccessDenied();
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
            $model              = new Author;
            $model->office_id   = CacheService::getInstance()->getOfficeId();
            $officeList         = DataListService::getOffice();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'officeList' => $officeList
                ]);
            }          
        }
        else{
            MessageHelper::getFlashAccessDenied();
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

        if (Yii::$app->user->can('update-author')) {
            try {
                $officeList = DataListService::getOffice();

                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post())) {
                    $urlTmpCrop = Yii::$app->urlManager->baseUrl.self::$pathTmpCrop;
                    $model->file_name = str_replace($urlTmpCrop, '', $model->file_name);
                    $model->file_name = str_replace('/', '', $model->file_name);

                    if ($model->save()) {
                        //DELETE OLD FILE
                        if(file_exists($urlTmpCrop.'/'.$model->file_name)) :
                            unlink($urlTmpCrop.'/'.$model->file_name);
                        endif;

                        ///MOVE DATA FROM TMP TO MODEL DIRECTORY
                        rename(str_replace('frontend', 'backend', Yii::getAlias('@webroot')).
                            self::$pathTmpCrop.'/'.$model->file_name, $model->getAssetFile());

                        MessageHelper::getFlashUpdateSuccess();
                        return $this->redirect(['view', 'id'=>$model->id, 'title'=>$model->title]);
                    } else {
                        MessageHelper::getFlashSaveFailed();
                    }
                }
                return $this->render('update', [
                    'model'=>$model,
                    'officeList'=>$officeList
                ]);
            } catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-author')){
            $model = $this->findModel($id);

            // validate deletion and on failure process any exception 
            // e.g. display an error message 
            if ($model->delete()) {
                MessageHelper::getFlashDeleteSuccess();
                if (!$model->deleteAsset()) {
                    MessageHelper::getFlashDeleteAssetFailed();
                }
            }

            return $this->redirect(['index']);        
        }
        else{
            MessageHelper::getFlashAccessDenied();
            return throw new ForbiddenHttpException;
        }
    }

    public function actionDeleteFile($id)
    {
        if (Yii::$app->user->can('delete-author')) {
            $model = Author::find()->where(['id' => $id])->one();
            $model->deleteAsset();
            $model->save();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['author/view', 'id' => $model->id, 'title' => $model->title]);
        } else {
            MessageHelper::getFlashLoginInfo();
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
