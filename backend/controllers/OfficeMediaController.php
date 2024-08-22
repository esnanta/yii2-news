<?php

namespace backend\controllers;


use common\helper\IconHelper;
use common\helper\MessageHelper;
use common\models\OfficeMedia;
use common\models\OfficeMediaSearch;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * OfficeMediaController implements the CRUD actions for OfficeMedia model.
 */
class OfficeMediaController extends Controller
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
     * Lists all OfficeMedia models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-officemedia')){
            $searchModel    = new OfficeMediaSearch;
            $dataProvider   = $searchModel->search(Yii::$app->request->getQueryParams());
            $officeList     = DataListService::getOffice();
            $mediaTypeList  = OfficeMedia::getArrayMediaType();
            $iconList       = IconHelper::getFontAwesomeBrands();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'officeList' => $officeList,
                'mediaTypeList' => $mediaTypeList,
                'iconList' => $iconList
            ]);
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single OfficeMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-officemedia')){
            $model          = $this->findModel($id);
            $officeList     = DataListService::getOffice();
            $mediaTypeList  = OfficeMedia::getArrayMediaType();
            $iconList       = IconHelper::getFontAwesomeBrands();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                MessageHelper::getFlashSaveSuccess();
                return $this->redirect(['office/view', 'id' => $model->office_id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'mediaTypeList' => $mediaTypeList,
                    'iconList' => $iconList
                ]);
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new OfficeMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        if(Yii::$app->user->can('create-officemedia')){
            $model              = new OfficeMedia;
            $model->office_id   = CacheService::getInstance()->getOfficeId();
            $model->media_type  = $type;
            $officeList         = DataListService::getOffice();
            $mediaTypeList      = OfficeMedia::getArrayMediaType();
            $iconList           = IconHelper::getFontAwesomeBrands();

            try {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    MessageHelper::getFlashSaveSuccess();
                    return $this->redirect(['office/view', 'id' => $model->office_id]);
                } 
                else {
                    return $this->render('create', [
                        'model' => $model,
                        'officeList' => $officeList,
                        'mediaTypeList' => $mediaTypeList,
                        'iconList' => $iconList
                    ]);
                }
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
     * Updates an existing OfficeMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-officemedia')){
            try {
                $model          = $this->findModel($id);
                $officeList     = DataListService::getOffice();
                $mediaTypeList  = OfficeMedia::getArrayMediaType();
                $iconList       = IconHelper::getFontAwesomeBrands();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    MessageHelper::getFlashUpdateSuccess();
                    return $this->redirect(['office/view', 'id' => $model->office_id]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                        'officeList' => $officeList,
                        'mediaTypeList' => $mediaTypeList,
                        'iconList' => $iconList
                    ]);
                }
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
     * Deletes an existing OfficeMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-officemedia')){
            $model = $this->findModel($id);
            $model->delete();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['office/view', 'id' => $model->office_id]);
        }
        else{
            MessageHelper::getFlashLoginInfo();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the OfficeMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OfficeMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OfficeMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
