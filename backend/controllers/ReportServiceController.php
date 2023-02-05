<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\Staff;
use backend\models\Service;
use backend\models\ServiceDetail;

use common\models\ReportService;
use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;




/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportServiceController extends Controller
{   

    public function actionService()
    {

        $model              = new ReportService();
        $staffList          = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
        $dateAttributeList  = ['date_issued'=>'Date Issued'];

        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;
            $title          = 'SERVICE';
            $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();

            $writer         = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $dateFirst      = $model->date_first;
            $dateLast       = $model->date_last;
            $query          = Service::find()
                                ->where(['between', $model->option_date,  $dateFirst,  $dateLast])
                                ->orderBy(['date_issued'=>SORT_ASC]);

            if(!empty($model->customer_id)){
                $query->andWhere(['customer_id'=>$model->customer_id]);
            }
            if(!empty($model->staff_id)){
                $query->andWhere(['staff_id'=>$model->staff_id]);
            }

            $countRecords       = ($query->count()== null) ? '0' : $query->count() ;

            $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');

            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'',' ('.$rangeDate.')']);
            $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print'  ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $rowTableHeader     = WriterEntityFactory::createRowFromArray(['No','Nomor','Pelanggan','Staff','Title','Invoice','Issued','Description'], $headerStyle);
            
            if($model->option_detail){
                $rowTableHeader     = WriterEntityFactory::createRowFromArray([
                    'No','Nomor','Pelanggan','Staff','Title','Invoice','Issued','Description',
                    'Outlet','Alasan','Status','Catatan','Biaya'
                ], $headerStyle);
            }
            
            $writer->addRows([
                $rowTitle,$rowTotalRecords,$rowTanggalPrint,$rowEmpty,
                $rowTableHeader
            ]);

            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                //CEK BAGIAN ELSE
                $cellValues = [
                    ($i+1), 
                    $recordModel->enrolment->title,
                    $recordModel->customer->title,
                    $recordModel->staff->title,
                    $recordModel->title,
                    $recordModel->invoice,
                    Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                    $recordModel->description
                ];
                
                if($model->option_detail){

                    $queryDetails = ServiceDetail::find()->where(['service_id'=>$recordModel->id]);
                    foreach ($queryDetails->each($dataEachLimit) as $j => $queryDetailModel) {

                        $outletDeviceType = $queryDetailModel->outletDetail->getOneDeviceType($queryDetailModel->outletDetail->device_type);
                        $serviceDeviceStatus = $queryDetailModel->getOneDeviceStatus($queryDetailModel->device_status);

                        $cellValues = [
                            
                            ($i+1), 
                            $recordModel->enrolment->title,
                            $recordModel->customer->title,
                            $recordModel->staff->title,
                            $recordModel->title,
                            $recordModel->invoice,
                            Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                            $recordModel->description,                           
                            strip_tags($outletDeviceType),
                            $queryDetailModel->serviceReason->title,
                            strip_tags($serviceDeviceStatus),
                            $queryDetailModel->commentary,
                            $queryDetailModel->claim
                        ];


                        $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                        $plunck_data[]  = $rowDetailCell;
                    }
                }                
                else{
                    $rowMasterCell  = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunck_data[]  = $rowMasterCell;                      
                }
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data); 
            $writer->close();

        }
        else {
            return $this->render('_form_service', [
                'model'             => $model,
                'dateAttributeList' => $dateAttributeList,
                'staffList'         => $staffList,
            ]);
        }
    }

}

