<?php

namespace frontend\controllers;

use Yii;
use backend\models\MailCategory;
use backend\models\MailCategorySearch;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * MailCategoryController implements the CRUD actions for MailCategory model.
 */
class MailCategoryController extends Controller
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
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    /**
     * Lists all MailCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-mail-category')){
            $searchModel = new MailCategorySearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Displays a single MailCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-mail-category')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', ['model' => $model]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Creates a new MailCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-mail-category')){
            $model = new MailCategory;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Updates an existing MailCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-mail-category')){
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
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Deletes an existing MailCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-mail-category')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Finds the MailCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
