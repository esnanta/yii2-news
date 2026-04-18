<?php

namespace frontend\controllers;

use common\models\Document;
use common\models\search\DocumentSearch;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DocumentController implements the actions for viewing and downloading Document models.
 */
class DocumentController extends Controller
{
    public $layout = '/column2_blog';

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'download' => ['GET'],
                    'preview' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Handles the download of a document.
     * Increments the download counter and sends the file to the user.
     *
     * @throws NotFoundHttpException if the model or file cannot be found
     */
    public function actionDownload(int $id): Response
    {
        $model = $this->findModel($id);
        $this->assertDocumentAccessible($model);
        $filePath = $model->getStorageFilePath();

        if (null === $filePath || !is_file($filePath)) {
            throw new NotFoundHttpException(\Yii::t('frontend', 'The requested file does not exist.'));
        }

        // Increment download counter
        $model->updateCounters(['download_count' => 1]);

        return \Yii::$app->response->sendFile($filePath, $model->name);
    }

    /**
     * Streams a document inline so it can be rendered by browser viewers.
     *
     * @throws NotFoundHttpException if the model or file cannot be found
     */
    public function actionPreview(int $id): Response
    {
        $model = $this->findModel($id);
        $this->assertDocumentAccessible($model);
        $filePath = $model->getStorageFilePath();

        if (null === $filePath || !is_file($filePath)) {
            throw new NotFoundHttpException(\Yii::t('frontend', 'The requested file does not exist.'));
        }

        $mimeType = !empty($model->type) ? (string) $model->type : (string) FileHelper::getMimeType($filePath);
        if ('' === $mimeType) {
            $mimeType = 'application/octet-stream';
        }

        return \Yii::$app->response->sendFile($filePath, $model->name, [
            'mimeType' => $mimeType,
            'inline' => true,
        ]);
    }

    /**
     * Lists all publicly visible Document models.
     */
    public function actionIndex(): string
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());

        // Ensure only public documents are shown
        $dataProvider->query->andWhere(['t_document.is_visible' => Document::FLAG_YES]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Document model.
     * Increments the view counter.
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        $model = $this->findModel($id);
        $this->assertDocumentAccessible($model);

        // Increment view counter
        $model->updateCounters(['view_count' => 1]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
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

        throw new NotFoundHttpException(\Yii::t('frontend', 'The requested page does not exist.'));
    }

    /**
     * Keeps private documents inaccessible for guests across view/preview/download endpoints.
     *
     * @throws NotFoundHttpException
     */
    protected function assertDocumentAccessible(Document $model): void
    {
        if (Document::FLAG_YES !== (int) $model->is_visible && \Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(\Yii::t('frontend', 'The requested page does not exist.'));
        }
    }
}
