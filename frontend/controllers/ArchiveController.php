<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\helper\ReportCloud;
use common\helper\Helper;

use backend\models\Archive;
use backend\models\ArchiveCategory;
use backend\models\ArchiveSearch;
use backend\models\ArchiveReport;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * ArchiveController implements the CRUD actions for Archive model.
 */
class ArchiveController extends Controller
{
    
    public $layout = "/column2_blog";
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionDownload($id,$title=null)
    {
        $model  = $this->findModel($id);
        $path   = $model->getAssetFile();
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
        if(Yii::$app->user->can('index-archive')){
            $searchModel            = new ArchiveSearch;
            $dataProvider           = $searchModel->search(Yii::$app->request->getQueryParams());
            if(Yii::$app->user->getIsGuest()){
                $dataProvider->query->andWhere('tx_archive.is_visible = '.Archive::IS_VISIBLE_PUBLIC);
            }

            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList          = Archive::getArrayIsVisible();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'archiveCategoryList'=>$archiveCategoryList,
                'isVisibleList' => $isVisibleList,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Displays a single Archive model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-archive')){
            $model                  = $this->findModel($id);
            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList          = Archive::getArrayIsVisible();

            $oldFile = $model->getAssetFile();
            $oldAvatar = $model->file_name;
            
            if ($model->load(Yii::$app->request->post())) {
                // process uploaded asset file instance
                $asset = $model->uploadAsset();

                // revert back if no valid file instance uploaded
                if ($asset === false) {
                    $model->file_name = $oldAvatar;
                    //$model->title = $oldFileName;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($asset !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getAssetFile();
                        $asset->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->id]);
                } else {
                    // error in saving model
                }
            }
            else {
                
                $model->view_counter    = $model->view_counter+1;
                $model->save();
                
                return $this->render('view', [
                    'model' => $model,
                    'archiveCategoryList'=>$archiveCategoryList,
                    'isVisibleList' => $isVisibleList,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }

    }

    /**
     * Creates a new Archive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-archive')){
            $model                  = new Archive;
            $model->date_issued     = time();
            $model->is_visible      = Archive::IS_VISIBLE_PRIVATE;
            
            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList          = Archive::getArrayIsVisible();

            try {
                if ($model->load(Yii::$app->request->post())) {
                    // process uploaded asset file instance
                    $asset = $model->uploadAsset();

                    if ($model->save()) {
                        // upload only if valid uploaded file instance found
                        if ($asset !== false) {
                            $path = $model->getAssetFile();
                            $asset->saveAs($path);
                        }
                        return $this->redirect(['view', 'id'=>$model->id]);
                    } else {
                        // error in saving model
                    }
                }
                return $this->render('create', [
                    'model' => $model,
                    'archiveCategoryList'=>$archiveCategoryList,
                    'isVisibleList' => $isVisibleList,
                ]);
            }
            catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }

    }

    /**
     * Updates an existing Archive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-archive')){
            $model                  = $this->findModel($id);
            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $isVisibleList          = Archive::getArrayIsVisible();

            $oldFile            = $model->getAssetFile();
            $oldAvatar          = $model->file_name;
            $oldFileName        = $model->title;

            try {
                if ($model->load(Yii::$app->request->post())) {
                    // process uploaded asset file instance
                    $asset = $model->uploadAsset();

                    // revert back if no valid file instance uploaded
                    if ($asset === false) {
                        $model->file_name = $oldAvatar;
                        $model->title = $oldFileName;
                    }

                    if ($model->save()) {
                        // upload only if valid uploaded file instance found
                        if ($asset !== false) { // delete old and overwrite
                            file_exists($oldFile) ? unlink($oldFile) : '' ;
                            $path = $model->getAssetFile();
                            $asset->saveAs($path);
                        }
                        return $this->redirect(['view', 'id'=>$model->id]);
                    } else {
                        // error in saving model
                    }
                }
                return $this->render('update', [
                    'model'=>$model,
                    'archiveCategoryList'=>$archiveCategoryList,
                    'isVisibleList' => $isVisibleList,
                ]);
            }
            catch (StaleObjectException $e) {
                throw new StaleObjectException('The object being updated is outdated.');
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }


    }

    /**
     * Deletes an existing Archive model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-archive')){
            $model = $this->findModel($id);

            // validate deletion and on failure process any exception
            // e.g. display an error message
            if ($model->delete()) {
                if (!$model->deleteAsset()) {
                    Yii::$app->session->setFlash('error', 'Error deleting file');
                }
            }

            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }

    }

    /**
     * Finds the Archive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Archive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Archive::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionReport()
    {
        if(Yii::$app->user->can('report-archive')){
            $model                  = new ArchiveReport;
            $archiveCategoryList    = ArrayHelper::map(ArchiveCategory::find()->asArray()->all(), 'id','title');
            $dateAttributeList      = ['date_issued'=>'Date Issued'];

            if ($model->load(Yii::$app->request->post())) {

                $formatter      = \Yii::$app->formatter;
                $title          = 'Arsip ';
                $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'d-MM-Y');
                $dateFirst      = $model->date_first;
                $dateLast       = $model->date_last;
                $query          = Archive::find()->where(['between', $model->option_date, $model->date_first, $model->date_last]);

                if(!empty($model->archive_category_id)){
                    $query->andWhere(['archive_category_id'=>$model->archive_category_id]);
                }

                $countRecords   = $query->count();

                $headerStyle    = ReportCloud::getHeaderStyle();
                $rowStyle       = ReportCloud::getRowStyle();

                $writer = ReportCloud::getWriterFactory();
                $writer->openToBrowser($filename.ReportCloud::getFileExtension());
                $writer->getCurrentSheet();
                $writer->setDefaultRowStyle($rowStyle);

                $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'d-MM-Y').' - '.Yii::$app->formatter->asDate($dateLast,'d-MM-Y');
                $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
                $rowTitle           = WriterEntityFactory::createRowFromArray([$title.' ('.$rangeDate.')']);
                $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print ','',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);

                $writer->addRows([$rowTitle,$rowTanggalPrint]);

                $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records','',$formatter->asDecimal($countRecords)]);
                $rowTableTitle      = WriterEntityFactory::createRowFromArray([
                                        'No','Judul','Tanggal',
                                        'Kategori','Akses',
                                        'Aset','Deskripsi'], $headerStyle);

                $writer->addRows([$rowTotalRecords,$rowEmpty,$rowTableTitle]);


                $plunck_data    = [];
                $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
                foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                    //$MODEL ADALAH FORM
                    //$RECORMODEL ADALAH DATANYA
                    $categoryTitle      = $recordModel->archiveCategory->title;
                    $isVisible          = strip_tags($recordModel->getOneIsVisible($recordModel->is_visible));

                    $cellValues = [
                        ($i+1),
                        $recordModel->title,
                        Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                        $categoryTitle,
                        $isVisible,
                        $recordModel->file_name,
                        strip_tags($recordModel->description),
                    ];

                    $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunck_data[]  = $rowDetailCell;
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunck_data);
                $writer->close();
            }
            else {
                return $this->render('_form_report', [
                    'model' => $model,
                    'archiveCategoryList' => $archiveCategoryList,
                    'dateAttributeList' => $dateAttributeList
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        } 
    }
}
