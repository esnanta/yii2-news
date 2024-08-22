<?php

namespace backend\controllers;

use common\helper\MessageHelper;
use common\models\StaffMedia;
use common\models\StaffMediaSearch;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * StaffMediaController implements the CRUD actions for StaffMedia model.
 */
class StaffMediaController extends Controller
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
     * Lists all StaffMedia models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-staffmedia')){
                            $searchModel = new StaffMediaSearch;
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
     * Displays a single StaffMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-staffmedia')){
            $model      = $this->findModel($id);
            $officeList = DataListService::getOffice();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['staff/view', 'id' => $model->staff_id]);
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
     * Creates a new StaffMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws StaleObjectException
     */
    public function actionCreate($staff,$type)
    {
        if(Yii::$app->user->can('create-staffmedia')){
            $model              = new StaffMedia;
            $model->office_id   = CacheService::getInstance()->getOfficeId();
            $model->staff_id    = $staff;
            $model->media_type  = $type;

            $officeList = DataListService::getOffice();

            try {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    MessageHelper::getFlashSaveSuccess();
                    return $this->redirect(['staff/view', 'id' => $model->staff_id]);
                } 
                else {
                    return $this->render('create', [
                        'model' => $model,
                        'officeList' => $officeList,
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
     * Updates an existing StaffMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws StaleObjectException
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-staffmedia')){
            try {
                $model      = $this->findModel($id);
                $officeList = DataListService::getOffice();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    MessageHelper::getFlashUpdateSuccess();
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
     * Deletes an existing StaffMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-staffmedia')){
            $model      = $this->findModel($id);
            $staffId    = $model->staff_id;
            $model->delete();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['staff/view', 'id' => $staffId]);
        }
        else{
            MessageHelper::getFlashDeleteFailed();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the StaffMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
