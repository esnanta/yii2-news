<?php

namespace frontend\controllers;

use backend\models\MailOutgoing;
use backend\models\MailOutgoingSearch;
use backend\models\MailOutgoingReport;
use backend\models\MailCategory;
use backend\models\MailType;

use common\helper\ReportCloud;
use common\helper\Helper;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * MailOutgoingController implements the CRUD actions for MailOutgoing model.
 */
class MailOutgoingController extends Controller
{
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
     * Lists all MailOutgoing models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-mail-outgoing')){
            $searchModel = new MailOutgoingSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            if(Yii::$app->user->getIsGuest()){
                $dataProvider->query->andWhere('is_visible = '.MailOutgoing::IS_VISIBLE_PUBLIC);
            }
            
            $mailCategoryList       = ArrayHelper::map(MailCategory::find()->asArray()->all(), 'id','title');
            $mailTypeList           = ArrayHelper::map(MailType::find()->asArray()
                                        ->where(['group_type'=> MailType::GROUP_TYPE_OUTGOING])
                                        ->all(), 'id','title');
            $isVisibleList          = MailOutgoing::getArrayIsVisible();

            return $this->render('index', [
                'dataProvider'      => $dataProvider,
                'searchModel'       => $searchModel,
                'mailCategoryList'  => $mailCategoryList,
                'mailTypeList'      => $mailTypeList,   
                'isVisibleList'     => $isVisibleList,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
            
    }

    /**
     * Displays a single MailOutgoing model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-mail-outgoing')){
            $model                  = $this->findModel($id);
            $mailCategoryList       = ArrayHelper::map(MailCategory::find()->asArray()->all(), 'id','title');
            $mailTypeList           = ArrayHelper::map(MailType::find()->asArray()
                                        ->where(['group_type'=> MailType::GROUP_TYPE_OUTGOING])
                                        ->all(), 'id','title');
            $isVisibleList          = MailOutgoing::getArrayIsVisible();

            $oldFile                = $model->getAssetFile();
            $oldAsset               = $model->asset;

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $asset = $model->uploadAsset();

                // revert back if no valid file instance uploaded
                if ($asset === false) {
                    $model->asset = $oldAsset;
                }

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($asset !== false) { // delete old and overwrite
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getAssetFile();
                        $asset->saveAs($path);
                    }
                    return $this->redirect(['view', 'id'=>$model->id, 'title'=>$model->title]);
                } 
                else {
                    // error in saving model
                }
            }        
            else {
                
                $model->view_counter    = $model->view_counter+1;
                $model->save();
                
                return $this->render('view', [
                    'model'             => $model,
                    'mailCategoryList'  => $mailCategoryList,
                    'mailTypeList'      => $mailTypeList,
                    'isVisibleList'     => $isVisibleList,
                ]);
            }
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
            
    }

    /**
     * Creates a new MailOutgoing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-mail-outgoing')){
            $model                  = new MailOutgoing;
            $model->date_issued     = time();
            $model->is_visible      = MailOutgoing::IS_VISIBLE_PRIVATE;
            
            $mailCategoryList       = ArrayHelper::map(MailCategory::find()->asArray()->all(), 'id','title');
            $mailTypeList           = ArrayHelper::map(MailType::find()->asArray()
                                        ->where(['group_type'=> MailType::GROUP_TYPE_OUTGOING])
                                        ->all(), 'id','title');
            $isVisibleList          = MailOutgoing::getArrayIsVisible();

            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $asset = $model->uploadAsset();    

                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($asset !== false) {
                        $path = $model->getAssetFile();
                        $asset->saveAs($path);
                    }
                    return $this->redirect(['view', 'id' => $model->id,'title'=>$model->title]);
                } else {
                    // error in saving model
                }
            }

            return $this->render('create', [
                'model'             => $model,
                'mailCategoryList'  => $mailCategoryList,
                'mailTypeList'      => $mailTypeList,
                'isVisibleList'     => $isVisibleList,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }  
    }

    /**
     * Updates an existing MailOutgoing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-mail-outgoing')){
            $model                  = $this->findModel($id);
            $mailCategoryList       = ArrayHelper::map(MailCategory::find()->asArray()->all(), 'id','title');
            $mailTypeList           = ArrayHelper::map(MailType::find()->asArray()
                                        ->where(['group_type'=> MailType::GROUP_TYPE_OUTGOING])
                                        ->all(), 'id','title');
            $isVisibleList          = MailOutgoing::getArrayIsVisible();

            $oldFile                = $model->getAssetFile();
            $oldAsset               = $model->asset;
            
            if ($model->load(Yii::$app->request->post())) {
                // process uploaded image file instance
                $asset = $model->uploadAsset();    
                // revert back if no valid file instance uploaded
                if ($asset === false) {
                    $model->asset = $oldAsset;
                }
                
                if ($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($asset !== false) {
                        file_exists($oldFile) ? unlink($oldFile) : '' ;
                        $path = $model->getAssetFile();
                        $asset->saveAs($path);
                    }
                    return $this->redirect(['view', 'id' => $model->id,'title'=>$model->title]);
                } else {
                    // error in saving model
                }
            }

            return $this->render('update', [
                'model' => $model,
                'mailCategoryList'  => $mailCategoryList,
                'mailTypeList'      => $mailTypeList,
                'isVisibleList'     => $isVisibleList,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Deletes an existing MailOutgoing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-mail-outgoing')){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash(Yii::$app->params['LabelMessage'], ['message' => Yii::t('app', Helper::getLoginInfo())]);
            throw new ForbiddenHttpException(Yii::t('app', Helper::getAccessDenied()));
        }
    }

    /**
     * Finds the MailOutgoing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailOutgoing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailOutgoing::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionReport()
    {
        if(Yii::$app->user->can('report-mail-outgoing')){
            $model                  = new MailOutgoingReport;
            $mailCategoryList       = ArrayHelper::map(MailCategory::find()->asArray()->all(), 'id','title');
            $mailTypeList           = ArrayHelper::map(MailType::find()->asArray()
                                        ->where(['group_type'=> MailType::GROUP_TYPE_OUTGOING])
                                        ->all(), 'id','title');
            $dateAttributeList      = ['date_issued'=>'Date Issued'];

            if ($model->load(Yii::$app->request->post())) {

                $formatter      = \Yii::$app->formatter;
                $title          = 'Surat Keluar Pertanggal ';
                $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'d-MM-Y');
                $dateFirst      = $model->date_first;
                $dateLast       = $model->date_last;
                $query          = MailOutgoing::find()->where(['between', $model->option_date, $model->date_first, $model->date_last]);
                $query->andWhere(['mail_type_id'=> $model->mail_type_id]);

                if(!empty($model->mail_category_id)){
                    $query->andWhere(['mail_category_id'=>$model->mail_category_id]);
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
                                        'No','Judul','Tanggal','No Surat',
                                        'Kepada','Kode','Jenis','Kategori',
                                        'Aset','Visible','Deskripsi'], $headerStyle);

                $writer->addRows([$rowTotalRecords,$rowEmpty,$rowTableTitle]);


                $plunck_data    = [];
                $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
                foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                    //$MODEL ADALAH FORM
                    //$RECORMODEL ADALAH DATANYA
                    $categoryTitle      = (!empty($recordModel->mail_category_id)) ? $recordModel->mailCategory->title:'-';
                    $isVisible          = strip_tags($recordModel->getOneIsVisible($recordModel->is_visible));

                    $cellValues = [
                        ($i+1),
                        $recordModel->title,
                        Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                        $recordModel->remark,
                        $recordModel->addressed_to,
                        $recordModel->mailType->mail_code,
                        $recordModel->mailType->title,
                        $categoryTitle,
                        $recordModel->asset,
                        $isVisible,
                        strip_tags($recordModel->description)
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
                    'mailCategoryList' => $mailCategoryList,
                    'mailTypeList' => $mailTypeList,
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
