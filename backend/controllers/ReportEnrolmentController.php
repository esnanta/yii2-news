<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

use backend\models\Enrolment;
use backend\models\Network;
use backend\models\Area;
use backend\models\Collector;
use backend\models\Village;

use common\models\ReportEnrolment;
use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportEnrolmentController extends Controller
{

    public function actionDigital()
    {
        $model              = new ReportEnrolment;
        $dataList           = Enrolment::getArrayEnrolmentType();
        $dateAttributeList  = ['date_start'=>'Date Start', 'date_end'=>'Date End'];

        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;
            $title          = 'CUSTOMER DIGITAL '.$model->option_date;
            $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'d-MM-Y');
            $dateFirst      = $model->date_first;
            $dateLast       = $model->date_last;
            $query          = Enrolment::find()->where(['between', $model->option_date, $model->date_first, $model->date_last]);
            $query->andWhere(['enrolment_type'=> Enrolment::ENROLMENT_TYPE_DIGITAL]);
            
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
            $rowTableTitle      = WriterEntityFactory::createRowFromArray(['No','Number','Name','Address','Phone','Issued',
                                    'Village','Area','Collector','Network',
                                    'Mulai','Selesai','Valid','Expired'], $headerStyle);

            $writer->addRows([$rowTotalRecords,$rowEmpty,$rowTableTitle]);


            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $villageId      = $recordModel->customer->village_id;
                $areaId         = $recordModel->customer->area_id;
                $networkId      = $recordModel->network_id;

                $areaTitle      = Area::find()->where(['id'=>$areaId])->one()->title;
                $villageTitle   = Village::find()->where(['id'=>$villageId])->one()->title;
                $networkTitle   = Network::find()->where(['id'=>$networkId])->one()->title;
                $collectors     = Collector::getListByArea($areaId);

                $cellValues = [
                    ($i+1),
                    $recordModel->customer->customer_number,
                    $recordModel->customer->title,
                    $recordModel->customer->address,
                    $recordModel->customer->phone_number,
                    Yii::$app->formatter->format($recordModel->customer->date_issued, 'date'),
                    $villageTitle,
                    $areaTitle,
                    (!empty($collectors)) ? '':$collectors,
                    $networkTitle,
                    Yii::$app->formatter->asDate($recordModel->date_start,'dd/MM/yy'),
                    Yii::$app->formatter->asDate($recordModel->date_end,'dd/MM/yy'),
                    $recordModel->getDaysOfValid(),
                    $recordModel->getDaysOfExpired(),
                ];
                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data);
            $writer->close();
        }
        else {
            return $this->render('_form_enrolment', [
                'model' => $model,
                'dataList' => $dataList,
                'dateAttributeList' => $dateAttributeList
            ]);
        }
    }
}