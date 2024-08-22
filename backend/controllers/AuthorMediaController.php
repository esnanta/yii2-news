<?php

namespace backend\controllers;

use common\helper\MessageHelper;
use common\models\AuthorMedia;
use common\models\AuthorMediaSearch;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * AuthorMediaController implements the CRUD actions for AuthorMedia model.
 */
class AuthorMediaController extends Controller
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
     * Lists all AuthorMedia models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-authormedia')){
                            $searchModel = new AuthorMediaSearch;
                $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
                $officeList = DataListService::getOffice();

                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'officeList' => $officeList,
                ]);
                    }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single AuthorMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-authormedia')){
            $model      = $this->findModel($id);
            $officeList = DataListService::getOffice();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['author/view', 'id' => $model->author_id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'officeList' => $officeList,
                ]);
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new AuthorMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws StaleObjectException
     */
    public function actionCreate($author,$type)
    {
        if(Yii::$app->user->can('create-authormedia')){
            $model              = new AuthorMedia;
            $model->office_id   = CacheService::getInstance()->getOfficeId();
            $model->author_id   = $author;
            $model->media_type  = $type;
            $officeList         = DataListService::getOffice();

            try {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    MessageHelper::getFlashSaveSuccess();
                    return $this->redirect(['author/view', 'id' => $model->author_id]);
                } 
                else {
                    return $this->render('create', [
                        'model' => $model,
                        'officeList' => $officeList
                    ]);
                }
            }
            catch (StaleObjectException $e) {
                MessageHelper::getFlashSaveFailed();
                throw new StaleObjectException('The object being updated is outdated.');
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing AuthorMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws StaleObjectException
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-authormedia')){
            try {
                $model      = $this->findModel($id);
                $officeList = DataListService::getOffice();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    MessageHelper::getFlashSaveSuccess();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                        'officeList' => $officeList,
                    ]);
                }
            }
            catch (StaleObjectException $e) {
                MessageHelper::getFlashUpdateFailed();
                throw new StaleObjectException('The object being updated is outdated.');
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing AuthorMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-authormedia')){
            $model      = $this->findModel($id);
            $authorId    = $model->author_id;
            $model->delete();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['author/view', 'id' => $authorId]);
        }
        else{
            MessageHelper::getFlashDeleteFailed();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the AuthorMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthorMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthorMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
