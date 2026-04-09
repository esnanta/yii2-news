<?php

namespace backend\modules\content\controllers;

use common\base\BaseController;
use common\models\DocumentCategory;
use common\models\search\DocumentCategorySearch;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DocumentCategoryController implements the CRUD actions for the DocumentCategory model.
 */
class DocumentCategoryController extends BaseController
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
     * Lists all DocumentCategory models.
     *
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('documentCategory.index');

        $searchModel = new DocumentCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumentCategory model.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $this->checkAccess('documentCategory.view');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DocumentCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $this->checkAccess('documentCategory.create');

        $model = new DocumentCategory();

        if (
            $model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocumentCategory model.
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
        $this->checkAccess('documentCategory.update');

        $model = $this->findModel($id);

        if (
            $model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentCategory model.
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
        $this->checkAccess('documentCategory.delete');
        $model->deleteSafely();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocumentCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return DocumentCategory the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): DocumentCategory
    {
        if (($model = DocumentCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
