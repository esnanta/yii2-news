<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;

use backend\models\Quote;
use backend\models\QuoteSearch;

use common\helper\Helper;

/**
 * QuoteController implements the CRUD actions for Quote model.
 */
class QuoteController extends Controller
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
                'class' => 'developit\jcrop\actions\Upload',
                'url' => Yii::$app->urlManager->baseUrl.self::$pathTmpCrop,
                'path' => Yii::getAlias('@webroot').self::$pathTmpCrop,
                'name' => Yii::$app->security->generateRandomString(),   
                'width'=> '400',
                'height'=> '400' ,    
                'maxSize'=> 4097152,          
            ]
        ];
    }      
    
    /**
     * Lists all Quote models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-quote')){
            $searchModel = new QuoteSearch;
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
     * Displays a single Quote model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-quote')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', ['model' => $model]);
            }          
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 
        
    }

    /**
     * Creates a new Quote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-quote')){
            $model = new Quote;

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
     * Updates an existing Quote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-quote')){
            $model = $this->findModel($id);

            $oldFile = $model->getImageFile();

            if ($model->load(Yii::$app->request->post())) {

                $urlTmpCrop = Yii::$app->urlManager->baseUrl.self::$pathTmpCrop;
                $model->file_name = str_replace($urlTmpCrop, '', $model->file_name);
                $model->file_name = substr($model->file_name, 0, strpos($model->file_name, "?"));    
                
                if ($model->save()) {
                    //DELETE FILE LAMA
                    file_exists($oldFile) ? unlink($oldFile) : '' ;
                    //PINDAHIN DATA DARI TMP KE DIREKTORI MODEL
                    rename(Yii::getAlias('@webroot').self::$pathTmpCrop.$model->file_name, $model->getImageFile());
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
     * Deletes an existing Quote model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-quote')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        } 
    }

    /**
     * Finds the Quote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
