<?php

namespace frontend\controllers;

use backend\models\AssetReport;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use common\helper\ReportCloud;
use common\models\Asset;
use common\models\AssetCategory;
use common\models\AssetSearch;
use common\service\DataListService;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * ArchiveController implements the CRUD actions for Archive model.
 */
class AssetController extends Controller
{

    public $layout = "/column2_blog";

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
        } else {
            throw new NotFoundHttpException("can't find {$model->title} file");
        }
    }

    /**
     * Lists all Archive models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new AssetSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        if (Yii::$app->user->getIsGuest()) {
            $dataProvider->query->andWhere('tx_asset.is_visible = ' . Asset::IS_VISIBLE_PUBLIC);
        }

        $assetCategoryList = DataListService::getAssetCategory();
        $isVisibleList = Asset::getArrayIsVisible();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'archiveCategoryList' => $assetCategoryList,
            'isVisibleList' => $isVisibleList,
        ]);

    }

    /**
     * Displays a single Archive model.
     * @param integer $id
     * @return mixed
     * @throws Exception
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $assetCategoryList = DataListService::getAssetCategory();
        $isVisibleList = Asset::getArrayIsVisible();

        $oldFile = $model->getAssetFile();
        $oldAvatar = $model->asset_name;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded asset file instance
            $asset = $model->uploadAsset();

            // revert back if no valid file instance uploaded
            if ($asset === false) {
                $model->asset_name = $oldAvatar;
                //$model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($asset !== false && file_exists($oldFile)) { // delete old and overwrite
                    if (file_exists($oldFile)):
                        unlink($oldFile);
                    endif;
                    $path = $model->getAssetFile();
                    $asset->saveAs($path);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else {

            //$model->view_counter = $model->view_counter + 1;
            //$model->save();

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
     * @param integer $id
     * @return Asset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asset::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReport()
    {
        if (Yii::$app->user->can('report-archive')) {
            $model = new AssetReport;
            $assetCategoryList = ArrayHelper::map(AssetCategory::find()->asArray()->all(), 'id', 'title');
            $dateAttributeList = ['date_issued' => 'Date Issued'];

            if ($model->load(Yii::$app->request->post())) {

                $formatter = \Yii::$app->formatter;
                $title = 'Arsip ';
                $filename = $title . ' ' . Yii::$app->formatter->asDate(time(), 'd-MM-Y');
                $dateFirst = $model->date_first;
                $dateLast = $model->date_last;
                $query = Asset::find()->where(['between', $model->option_date, $model->date_first, $model->date_last]);

                if (!empty($model->archive_category_id)) {
                    $query->andWhere(['archive_category_id' => $model->archive_category_id]);
                }

                $countRecords = $query->count();

                $headerStyle = ReportCloud::getHeaderStyle();
                $rowStyle = ReportCloud::getRowStyle();

                $writer = ReportCloud::getWriterFactory();
                $writer->openToBrowser($filename . ReportCloud::getFileExtension());
                $writer->getCurrentSheet();
                $writer->setDefaultRowStyle($rowStyle);

                $rangeDate = Yii::$app->formatter->asDate($dateFirst, 'd-MM-Y') . ' - ' . Yii::$app->formatter->asDate($dateLast, 'd-MM-Y');
                $rowEmpty = WriterEntityFactory::createRowFromArray(['']);
                $rowTitle = WriterEntityFactory::createRowFromArray([$title . ' (' . $rangeDate . ')']);
                $rowTanggalPrint = WriterEntityFactory::createRowFromArray(['Tanggal Print ', '', Yii::$app->formatter->asDate(time(), 'dd/MM/yy HH:mm:ss')]);

                $writer->addRows([$rowTitle, $rowTanggalPrint]);

                $rowTotalRecords = WriterEntityFactory::createRowFromArray(['Total Records', '', $formatter->asDecimal($countRecords)]);
                $rowTableTitle = WriterEntityFactory::createRowFromArray([
                    'No', 'Judul', 'Tanggal',
                    'Kategori', 'Akses',
                    'Aset', 'Deskripsi'], $headerStyle);

                $writer->addRows([$rowTotalRecords, $rowEmpty, $rowTableTitle]);


                $plunck_data = [];
                $dataEachLimit = Yii::$app->params['Data_Each_Limit'];
                foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                    //$MODEL ADALAH FORM
                    //$RECORMODEL ADALAH DATANYA
                    $categoryTitle = $recordModel->archiveCategory->title;
                    $isVisible = strip_tags($recordModel->getOneIsVisible($recordModel->is_visible));

                    $cellValues = [
                        ($i + 1),
                        $recordModel->title,
                        Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                        $categoryTitle,
                        $isVisible,
                        $recordModel->file_name,
                        strip_tags($recordModel->description),
                    ];

                    $rowDetailCell = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunck_data[] = $rowDetailCell;
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunck_data);
                $writer->close();
            } else {
                return $this->render('_form_report', [
                    'model' => $model,
                    'archiveCategoryList' => $assetCategoryList,
                    'dateAttributeList' => $dateAttributeList
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', DateUseCase::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', DateUseCase::getAccessDenied()));
        }
    }
}
