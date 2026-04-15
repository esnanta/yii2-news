<?php

namespace frontend\controllers;

use common\models\Document;
use common\models\search\DocumentSearch;
use common\service\DataListService;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ArchiveController implements the CRUD actions for Archive model.
 */
class DocumentController extends Controller
{
    public $layout = '/column2_blog';

    public function behaviors()
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

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionDownload($id, $title = null)
    {
        $model = $this->findModel($id);
        $path = $model->getAssetFile();
        if (!empty($path)) {
            return $model->downloadFile($path);
        }

        throw new NotFoundHttpException("can't find {$model->title} file");
    }

    /**
     * Lists all Archive models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        if (\Yii::$app->user->getIsGuest()) {
            $dataProvider->query->andWhere('t_document.is_visible = '.Document::FLAG_YES);
        }

        $assetCategoryList = DataListService::getDocumentCategory();
        $isVisibleList = Document::visibleOptions();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'archiveCategoryList' => $assetCategoryList,
            'isVisibleList' => $isVisibleList,
        ]);
    }

    /**
     * Displays a single Archive model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);
        $assetCategoryList = DataListService::getDocumentCategory();
        $isVisibleList = Document::visibleOptions();

        $oldFile = $model->getAssetFile();
        $oldAvatar = $model->asset_name;

        if ($model->load(\Yii::$app->request->post())) {
            // process uploaded asset file instance
            $asset = $model->uploadAsset();

            // revert back if no valid file instance uploaded
            if (false === $asset) {
                $model->asset_name = $oldAvatar;
                // $model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if (false !== $asset && file_exists($oldFile)) { // delete old and overwrite
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                    $path = $model->getAssetFile();
                    $asset->saveAs($path);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            // $model->view_counter = $model->view_counter + 1;
            // $model->save();

            return $this->render('view', [
                'model' => $model,
                'archiveCategoryList' => $assetCategoryList,
                'isVisibleList' => $isVisibleList,
            ]);
        }
    }

    /**
     * Finds the Archive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
