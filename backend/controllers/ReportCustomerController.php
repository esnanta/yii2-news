<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\Customer;
use backend\models\EnrolmentSearch;
use backend\models\Enrolment;
use backend\models\Village;
use backend\models\VillageSearch;
use backend\models\Collector;
use backend\models\Area;
use backend\models\Network;
use backend\models\ReceivableDetail;

use common\models\ReportCustomer;
use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportCustomerController extends Controller
{



    public function actionVillage($id=null)
    {
        $model              = new ReportCustomer;
        $searchModel        = new VillageSearch;
        $dataProvider       = $searchModel->search(Yii::$app->request->getQueryParams());

        $areaList           = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');

        if (!empty($id)) {

            $formatter      = \Yii::$app->formatter;
            $village        = Village::find()->where(['id'=>$id])->one();
            $query          = Customer::find()->where(['village_id'=>$village->id]);
            $filename       = 'CUSTOMER '.$village->title.' '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');


            $countRecords   = $query->count();

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();

            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray(['CUSTOMER By Desa']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print ','',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);

            $writer->addRows([$rowTitle,$rowTanggalPrint]);

            $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records','',$formatter->asDecimal($countRecords)]);
            $rowTableTitle      = WriterEntityFactory::createRowFromArray(['No','Number','Name','Address','Phone','Issued',
                                    'Village','Area','Collector','Network'], $headerStyle);

            $writer->addRows([$rowTotalRecords,$rowEmpty,$rowTableTitle]);


            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $enrolment  = Enrolment::find()->where(['customer_id'=>$recordModel->id])->one();

                $villageId  = $recordModel->village_id;
                $areaId     = $recordModel->area_id;
                $networkId  = $enrolment->network_id;

                $village    = (!empty($villageId)) ? $recordModel->village->title : '-';
                $area       = (!empty($areaId)) ? $recordModel->area->title : '-';
                $collectors = (!empty($areaId)) ? Collector::getListByArea($areaId): '-';
                $network    = (!empty($networkId)) ? $enrolment->network->title : '-';

                $cellValues = [
                    ($i+1),
                    $recordModel->customer_number,
                    $recordModel->title,
                    $recordModel->address,
                    $recordModel->phone_number,
                    Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                    $village,
                    $area,
                    $collectors,
                    $network
                ];

                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;

            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data);
            $writer->close();


        }
        else {
            return $this->render('index_village', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'searchModel'=>$searchModel,
                'areaList'=>$areaList
            ]);
        }

    }

    public function actionHistory($id=null)
    {

        $searchModel        = new EnrolmentSearch;
        $areaList           = ArrayHelper::map(Area::find()->asArray()->all(), 'id', 'title');
        $villageList        = ArrayHelper::map(Village::find()->asArray()->all(), 'id', 'title');
        $networkList        = Network::getArrayList();
        $enrolmentTypeList  = Enrolment::getArrayEnrolmentType();
        $dataProvider       = $searchModel->search(Yii::$app->request->getQueryParams());

        if (!empty($id)) {

            $formatter      = \Yii::$app->formatter;

            $enrolment      = Enrolment::find()->where(['id'=>$id])->one();
            $query          = ReceivableDetail::find()->where(['customer_id'=> $enrolment->customer_id]);

            $filename       = 'History '.'['.$enrolment->title.'] '.$enrolment->customer->title;

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();

            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $countRecords       = ($query->count()== null) ? '0' : $query->count() ;

            $ontime             = 0;
            $overdue            = 0;
            $penaltyPaid        = 0;
            $penaltyUnpaid      = 0;

            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$filename]);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print ','',Yii::$app->formatter->asDate(time(),'dd-MM-yy HH:mm:ss')]);

            $writer->addRows([$rowTitle,$rowTanggalPrint,$rowEmpty]);

            $rowNama            = WriterEntityFactory::createRowFromArray(['Nama','','['.$enrolment->title.'] '.$enrolment->customer->title]);
            $rowPhoneNumber     = WriterEntityFactory::createRowFromArray(['Telpon','',$enrolment->customer->phone_number]);
            $rowAddress         = WriterEntityFactory::createRowFromArray(['Alamat','',$enrolment->customer->address]);
            $rowTableTitle      = WriterEntityFactory::createRowFromArray(['No','Invoice','Deskripsi','Issued','JTO','OVD','Claim','Penalty','Payment'], $headerStyle);
            $writer->addRows([$rowNama,$rowPhoneNumber,$rowAddress, $rowEmpty, $rowTableTitle]);

            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                if ($recordModel->overdue > 0){
                    $overdue    = $overdue + 1;
                }
                else{
                    $ontime     = $ontime+1;
                }

                if ($recordModel->overdue > 0 && $recordModel->penalty > 0){
                    $penaltyPaid    = $penaltyPaid + $recordModel->penalty;
                }
                else if ($recordModel->overdue > 0 && $recordModel->penalty <= 0){
                    $penaltyUnpaid  = $penaltyUnpaid + $recordModel->penalty;
                }

                $billingType =(!empty($recordModel->billing->billing_type)) ?
                        $recordModel->billing->getOneBillingType($recordModel->billing->billing_type)  : '-';

                $cellValues = [
                    ($i+1),
                    $recordModel->receivable->invoice,
                    strip_tags($billingType),
                    Yii::$app->formatter->format($recordModel->receivable->date_issued, 'date'),
                    Yii::$app->formatter->format($recordModel->date_due, 'date'),
                    $recordModel->overdue,
                    (int)$recordModel->claim,
                    (int)$recordModel->penalty,
                    (int)$recordModel->payment
                ];

                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data);
            $writer->addRows([$rowEmpty]);

            $rowTotalRecords        = WriterEntityFactory::createRowFromArray(['Total Records','',$formatter->asDecimal($countRecords)]);
            $rowJumlahOnTime        = WriterEntityFactory::createRowFromArray(['Jumlah Ontime','',$formatter->asDecimal($ontime)]);
            $rowJumlahOverdue       = WriterEntityFactory::createRowFromArray(['Jumlah Overdue','',$formatter->asDecimal($overdue)]);
            $rowTotalPenaltiDibayar = WriterEntityFactory::createRowFromArray(['Jumlah Denda Dibayar','',$formatter->asDecimal($penaltyPaid)]);
            $rowTotalPenaltiHutang  = WriterEntityFactory::createRowFromArray(['Jumlah Denda Hutang','',$formatter->asDecimal($penaltyUnpaid)]);

            $writer->addRows([$rowTotalRecords,$rowJumlahOnTime,
                $rowJumlahOverdue,$rowTotalPenaltiDibayar,$rowTotalPenaltiHutang
            ]);
            $writer->close();

        }
        else {
            return $this->render('index_enrolment', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'networkList'=>$networkList,
                'areaList'=>$areaList,
                'villageList'=>$villageList,
                'enrolmentTypeList'=>$enrolmentTypeList,
            ]);
        }

    }
}