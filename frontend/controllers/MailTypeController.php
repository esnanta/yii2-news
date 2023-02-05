<?php

namespace frontend\controllers;

use Yii;
use backend\models\MailType;
use backend\models\MailTypeSearch;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * MailTypeController implements the CRUD actions for MailType model.
 */
class MailTypeController extends Controller
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
     * Lists all MailType models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-mail-type')){
            $searchModel    = new MailTypeSearch;
            $dataProvider   = $searchModel->search(Yii::$app->request->getQueryParams());
            $groupTypeList  = MailType::getArrayGroupType();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'groupTypeList' => $groupTypeList
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }

    }

    /**
     * Displays a single MailType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-mail-type')){
            $model          = $this->findModel($id);
            $groupTypeList  = MailType::getArrayGroupType();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id,'title'=>$model->title]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'groupTypeList' => $groupTypeList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
            
    }

    /**
     * Creates a new MailType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-mail-type')){
            $model = new MailType;
            $groupTypeList  = MailType::getArrayGroupType();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'groupTypeList' => $groupTypeList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
            
    }

    /**
     * Updates an existing MailType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-mail-type')){
            $model = $this->findModel($id);
            $groupTypeList  = MailType::getArrayGroupType();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'groupTypeList' => $groupTypeList
                ]);
            } 
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }

    }

    /**
     * Deletes an existing MailType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-mail-type')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }

    }

    /**
     * Finds the MailType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
