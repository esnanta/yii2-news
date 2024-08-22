<?php

namespace backend\controllers;


use common\helper\MessageHelper;
use common\helper\UIHelper;
use common\models\ArticleCategory;
use common\models\ArticleCategorySearch;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ArticleCategoryController extends Controller
{
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

    /**
     * Lists all Category models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-articlecategory')){
            $searchModel = new ArticleCategorySearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $dataList = ArticleCategory::getArrayTimeLine();
            
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'dataList'=>$dataList
            ]);        
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }          
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-articlecategory')){
            $model      = $this->findModel($id);
            $officeList = DataListService::getOffice();
            $dataList   = ArticleCategory::getArrayTimeLine();
            $labelList  = UIHelper::getLabelList();
            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'dataList'=>$dataList,
                    'labelList'=>$labelList
                ]);
            }         
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }         

    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-articlecategory')){
            $model              = new ArticleCategory;
            $model->office_id   = CacheService::getInstance()->getOfficeId();
            $officeList         = DataListService::getOffice();
            $dataList           = ArticleCategory::getArrayTimeLine();
            $labelList          = UIHelper::getLabelList();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'dataList' => $dataList,
                    'labelList' => $labelList
                ]);
            }           
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }        

    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-articlecategory')){
            $model = $this->findModel($id);
            $officeList = DataListService::getOffice();
            $dataList = ArticleCategory::getArrayTimeLine();
            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'dataList'=>$dataList
                ]);
            }          
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-articlecategory')){
            $this->findModel($id)->delete();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['index']);          
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
