<?php

namespace backend\controllers;

use Yii;
use backend\models\Archive;
use backend\models\ArchiveCategory;
use backend\models\ArchiveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use yii\db\StaleObjectException;

use common\helper\MessageHelper;
/**
 * ArchiveController implements the CRUD actions for Archive model.
 */
class ArchiveController extends Controller
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
     * Lists all Archive models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-archive')){
            $searchModel = new ArchiveSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $archiveCategoryList   = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList         = Archive::getArrayIsVisible();
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'archiveCategoryList' => $archiveCategoryList,
                'isVisibleList' => $isVisibleList,
            ]);
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Archive model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-archive')){
            $model                  = $this->findModel($id);
            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList          = Archive::getArrayIsVisible();
            
            $oldFile = $model->getAssetFile();
            $oldAvatar = $model->file_name;

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded asset file instance
                $asset = $model->uploadAsset();

                // revert back if no valid file instance uploaded
                if ($asset === false) {
                    $model->file_name = $oldAvatar;
                    //$model->title = $oldFileName;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($asset !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getAssetFile();
                        $asset->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->id]);
                } else {
                    // error in saving model
                }
            }
            else {
                return $this->render('view', [
                    'model' => $model,
                    'archiveCategoryList'=>$archiveCategoryList,
                    'isVisibleList' => $isVisibleList,
                ]);
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Archive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-archive')){
            $model = new Archive;
            $model->date_issued     = date(Yii::$app->params['dateDisplayFormat']);
            $model->is_visible      = Archive::IS_VISIBLE_PRIVATE;
            
            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList          = Archive::getArrayIsVisible();
            
            try {
                if ($model->load(Yii::$app->request->post())) {
                    // process uploaded asset file instance
                    $asset = $model->uploadAsset();

                    if ($model->save()) {
                        // upload only if valid uploaded file instance found
                        if ($asset !== false) {
                            $path = $model->getAssetFile();
                            $asset->saveAs($path);
                        }
                        return $this->redirect(['view', 'id'=>$model->id]);
                    } else {
                        // error in saving model
                    }
                }
                return $this->render('create', [
                    'model' => $model,
                    'archiveCategoryList'=>$archiveCategoryList,
                    'isVisibleList' => $isVisibleList,
                ]);
            }
            catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Archive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-archive')){
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
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Archive model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-archive')){
            $model = $this->findModel($id);
            // validate deletion and on failure process any exception
            // e.g. display an error message
            if ($model->delete()) {
                if (!$model->deleteAsset()) {
                    Yii::$app->session->setFlash('error', 'Error deleting file');
                }
            }
            return $this->redirect(['index']);
        }
        else{
            MessageHelper::getFlashLoginInfo();
            throw new ForbiddenHttpException;
        }
    }
    
    public function actionDeleteFile($id)
    {
        if(Yii::$app->user->can('delete-archive')){
            $model  = Archive::find()->where(['id'=>$id])->one();
            $model->deleteAsset();
            $model->save();
            Yii::$app->getSession()->setFlash('error', ['message' => Yii::t('app', 'File berhasil dihapus.')]);
            return $this->redirect(['archive/view', 'id' => $model->id, 'title'=>$model->title]);
        }
        else{
            MessageHelper::getFlashLoginInfo();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Archive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Archive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Archive::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
