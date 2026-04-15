<?php

namespace backend\modules\content\controllers;

use common\base\BaseController;
use common\models\Document;
use common\models\search\DocumentSearch;
use common\service\DataListService;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DocumentController implements the CRUD actions for the Document model.
 */
class DocumentController extends BaseController
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'download' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Lists all Document models.
     *
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('document.index');

        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'officeOptions' => DataListService::getOffice(),
            'documentCategoryOptions' => DataListService::getDocumentCategory(),
        ]);
    }

    /**
     * Displays a single Document model.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $this->checkAccess('document.view');

        return $this->render('view', [
            'model' => $this->findModel($id),
            'officeOptions' => DataListService::getOffice(),
            'documentCategoryOptions' => DataListService::getDocumentCategory(),
        ]);
    }

    /**
     * Downloads document file from storage.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDownload(int $id): Response
    {
        $this->checkAccess('document.view');

        $model = $this->findModel($id);
        $filePath = $model->getStorageFilePath();
        if (null === $filePath) {
            throw new NotFoundHttpException(\Yii::t('backend', 'Document file was not found.'));
        }

        $model->updateCounters(['download_count' => 1]);

        $options = ['inline' => false];
        if (!empty($model->type)) {
            $options['mimeType'] = $model->type;
        }

        return \Yii::$app->response->sendFile(
            $filePath,
            !empty($model->name) ? $model->name : basename($filePath),
            $options
        );
    }

    /**
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $this->checkAccess('document.create');

        $model = new Document();

        if ($model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'officeOptions' => DataListService::getOffice(),
            'documentCategoryOptions' => DataListService::getDocumentCategory(),
        ]);
    }

    /**
     * Updates an existing Document model.
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
        $this->checkAccess('document.update');

        $model = $this->findModel($id);

        if ($model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'officeOptions' => DataListService::getOffice(),
            'documentCategoryOptions' => DataListService::getDocumentCategory(),
        ]);
    }

    /**
     * Deletes an existing Document model.
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
        $this->checkAccess('document.delete');
        $model->deleteSafely();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return Document the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Document
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
