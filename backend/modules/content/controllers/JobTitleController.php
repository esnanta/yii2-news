<?php

namespace backend\modules\content\controllers;

use common\base\BaseController;
use common\models\JobTitle;
use common\models\search\JobTitleSearch;
use common\service\DataListService;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * JobTitleController implements the CRUD actions for the JobTitle model.
 */
class JobTitleController extends BaseController
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
     * Lists all JobTitle models.
     *
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('jobTitle.index');

        $searchModel = new JobTitleSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'officeOptions' => DataListService::getOffice(),
        ]);
    }

    /**
     * Displays a single JobTitle model.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $this->checkAccess('jobTitle.view');

        return $this->render('view', [
            'model' => $this->findModel($id),
            'officeOptions' => DataListService::getOffice(),
        ]);
    }

    /**
     * Creates a new JobTitle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $this->checkAccess('jobTitle.create');

        $model = new JobTitle();

        if ($model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'officeOptions' => DataListService::getOffice(),
        ]);
    }

    /**
     * Updates an existing JobTitle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $this->checkAccess('jobTitle.update');

        $model = $this->findModel($id);

        if ($model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'officeOptions' => DataListService::getOffice(),
        ]);
    }

    /**
     * Deletes an existing JobTitle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $this->checkAccess('jobTitle.delete');
        $model->deleteSafely();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobTitle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return JobTitle the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): JobTitle
    {
        if (($model = JobTitle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
