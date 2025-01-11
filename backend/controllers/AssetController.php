<?php

namespace backend\controllers;

use common\helper\DateHelper;
use common\helper\MessageHelper;
use common\helper\SpreadsheetHelper;
use common\models\Asset;
use common\models\AssetSearch;
use common\service\AssetService;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * AssetController implements the CRUD actions for Asset model.
 */
class AssetController extends Controller
{
    private AssetService $assetService;

    public function __construct($id, $module,
        AssetService $assetService, $config = [])
    {
        $this->assetService = $assetService;
        parent::__construct($id, $module, $config);
    }

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
     * Lists all Asset models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('index-asset')) {
            $searchModel = new AssetSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $officeList         = DataListService::getOffice();
            $assetCategoryList  = DataListService::getAssetCategory();
            $assetTypeList      = Asset::getArrayAssetType();

            $isVisibleList = Asset::getArrayIsVisible();
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'officeList' => $officeList,
                'assetCategoryList' => $assetCategoryList,
                'assetTypeList' => $assetTypeList,
                'isVisibleList' => $isVisibleList,
            ]);
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Asset model.
     * @param integer $id
     * @return mixed
     * @throws Exception
     */
    public function actionView($id, $title = null)
    {
        if (Yii::$app->user->can('view-asset')) {
            $model = $this->findModel($id);

            $officeList           = DataListService::getOffice();
            $assetCategoryList    = DataListService::getAssetCategory();
            $isVisibleList        = Asset::getArrayIsVisible();
            $assetTypeList        = Asset::getArrayAssetType();
            $fileExtensionList    = Asset::getArrayFileExtension();

            $renderIndexFileStatus = $this->assetService->renderIndexFileStatus($model);
            $currentFile    = $this->assetService->getAssetFile($model);
            $assetUrl       = $this->assetService->getAssetUrl($model);
            $fileData       = null;
            $fileType       = null; // Type of file: 'spreadsheet', 'image', 'document'
            $helper         = null;

            if (!empty($currentFile)) {
                try {
                    $fileExtension = strtolower(pathinfo($currentFile, PATHINFO_EXTENSION));

                    foreach ($fileExtensionList as $type => $extensions) {
                        if (in_array($fileExtension, $extensions)) {
                            $fileType = $type; // Assign the asset type integer
                            break;
                        }
                    }

                    if ($fileType === Asset::ASSET_TYPE_SPREADSHEET) {
                        $spreadsheetHelper = SpreadsheetHelper::getInstance();
                        $helper = $spreadsheetHelper->getHelper();
                        $reader = $spreadsheetHelper->getReader($currentFile);
                        $spreadsheet = $reader->load($currentFile);
                        $activeRange = $spreadsheet->getActiveSheet()->calculateWorksheetDataDimension();
                        $fileData = $spreadsheet->getActiveSheet()->rangeToArray(
                            $activeRange, null, true, true, true
                        );
                    } else  {
                        $fileData = $currentFile;
                    }

                } catch (\Exception $e) {
                    MessageHelper::getFlashAssetNotFound();
                }
            }

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded asset file instance
                $asset = $this->assetService->uploadAsset($model);

                if(!empty($asset)):
                    $model->asset_name  = $asset->name;
                    $model->asset_url = $this->assetService->getAssetUrl($model);
                endif;

                if ($model->save()) {
                    if ($asset !== false) {
                        if (file_exists($currentFile)) {
                            unlink($currentFile);
                        }
                        $path = $this->assetService->getAssetFile($model);
                        $asset->saveAs($path);
                    }
                    MessageHelper::getFlashUpdateSuccess();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('view', [
                'model' => $model,
                'officeList' => $officeList,
                'assetCategoryList' => $assetCategoryList,
                'isVisibleList' => $isVisibleList,
                'assetTypeList' => $assetTypeList,
                'assetUrl' => $assetUrl,
                'fileType' => $fileType,
                'helper' => $helper,
                'fileData' => $fileData,
                'renderIndexFileStatus' => $renderIndexFileStatus
            ]);
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException();
        }
    }

    /**
     * Creates a new Asset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-asset')) {

            $officeId             = CacheService::getInstance()->getOfficeId();
            $officeList           = DataListService::getOffice();
            $assetCategoryList    = DataListService::getAssetCategory();

            $model              = new Asset;
            $model->office_id   = $officeId;
            $model->date_issued = date(DateHelper::getDateSaveFormat());
            $model->is_visible  = Asset::IS_VISIBLE_PRIVATE;

            $assetTypeList = Asset::getArrayAssetType();
            $isVisibleList = Asset::getArrayIsVisible();

            try {
                if ($model->load(Yii::$app->request->post())) {
                    // process uploaded asset file instance
                    $asset = $this->assetService->uploadAsset($model);

                    if(empty($asset)){
                        MessageHelper::getFlashUploadFailed();
                    } else {
                        $model->asset_name = $asset->name;
                        $model->asset_url = $this->assetService->getAssetUrl($model);
                    }

                    if ($model->save()) :
                        // upload only if valid uploaded file instance found
                        if ($asset !== false) {
                            $path = $this->assetService->getAssetFile($model);
                            $asset->saveAs($path);
                        }
                        MessageHelper::getFlashUpdateSuccess();
                    endif;

                    return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('create', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'assetCategoryList' => $assetCategoryList,
                    'isVisibleList' => $isVisibleList,
                    'assetTypeList' => $assetTypeList,
                ]);
            } catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Asset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id,$title=null)
    {
        if (Yii::$app->user->can('update-asset')) {
            $model = $this->findModel($id);

            $officeList           = DataListService::getOffice();
            $assetCategoryList    = DataListService::getAssetCategory();

            $assetTypeList = Asset::getArrayAssetType();
            $isVisibleList = Asset::getArrayIsVisible();

            if ($model->load(Yii::$app->request->post())) {

                $asset = $this->assetService->uploadAsset($model);

                if(empty($asset)){
                    MessageHelper::getFlashAssetNotFound();
                } else {
                    $model->asset_name  = $asset->name;
                    $model->asset_url = $this->assetService->getAssetUrl($model);
                }

                if ($model->save()) :
                    // upload only if valid uploaded file instance found
                    if ($asset !== false) {
                        $path = $this->assetService->getAssetFile($model);
                        $asset->saveAs($path);
                    }
                    MessageHelper::getFlashUpdateSuccess();
                endif;

                MessageHelper::getFlashUpdateSuccess();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'assetCategoryList' => $assetCategoryList,
                    'isVisibleList' => $isVisibleList,
                    'assetTypeList' => $assetTypeList,
                ]);
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Asset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws Exception
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-asset')) {
            $model = $this->findModel($id);
            // validate deletion and on failure process any exception
            // e.g. display an error message
            if ($model->delete()) {
                if (!$this->assetService->deleteAsset($model)) {
                    Yii::$app->session->setFlash('error', 'Asset not found');
                }
            }
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['index']);
        } else {
            MessageHelper::getFlashLoginInfo();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * @throws Exception
     * @throws \yii\db\Exception
     * @throws ForbiddenHttpException
     */
    public function actionDeleteFile($id)
    {
        if (Yii::$app->user->can('delete-asset')) {
            $model = $this->findModel($id);
            $this->assetService->deleteAsset($model);
            $model->save();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['asset/view', 'id' => $model->id, 'title' => $model->title]);
        } else {
            MessageHelper::getFlashLoginInfo();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Asset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Asset
    {
        if (($model = Asset::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDownload($id, $title = null)
    {
        $model = $this->findModel($id);
        $path = $this->assetService->getAssetFile($model);
        if (!empty($path)) {
            return $model->downloadFile($path);
        } else {
            throw new NotFoundHttpException("can't find {$model->title} file");
        }
    }
}
