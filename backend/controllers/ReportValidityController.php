<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

use backend\models\Lookup;
use backend\models\Customer;
use backend\models\Collector;
use backend\models\Enrolment;
use backend\models\ValidityDetail;

use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportValidityController extends Controller
{


    public function actionPeriod($month,$attribute,$value)
    {

        $formatter      = \Yii::$app->formatter;
        $title          = 'Validity';

        $tmpFilename    = Lookup::getTitleById($value);
        $newFilename    = ($tmpFilename=='No') ? 'Belum Dibuat' : $tmpFilename;
        $filename       = $title. ' '.$newFilename.' '.$month;

        $headerStyle    = ReportCloud::getHeaderStyle();
        $rowStyle       = ReportCloud::getRowStyle();

        $writer = ReportCloud::getWriterFactory();
        $writer->openToBrowser($filename.ReportCloud::getFileExtension());
        $writer->getCurrentSheet();
        $writer->setDefaultRowStyle($rowStyle);

        $query = ValidityDetail::find()->where(['month_period'=>$month]);
        $query->andWhere([$attribute=>$value]);

        //KALAU YANG DIPILIH STATUS PEMBUATAN TAGIHAN
        //MAKA YANG DIBUATKAN TAGIHAN ADALAH YANG AKTIF SAJA
        //TAGIHAN YANG BELUM DIBUAT, HANYA DIHITUNG JIKA AKTIF
        if($attribute == 'billing_status'){
            $query->andWhere(['device_status'=> ValidityDetail::DEVICE_STATUS_ACTIVE]);
        }


        $totalAmount        = ($query->sum('amount')== null) ? '0' : $query->sum('amount');
        $countRecords       = ($query->count()== null) ? '0' : $query->count() ;

        $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
        $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'','('.$month.')']);
        $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print'  ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
        $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
        $rowTotalAmount     = WriterEntityFactory::createRowFromArray(['Total Amount'   ,'',$formatter->asDecimal($totalAmount)]);
        $writer->addRows([$rowTitle,$rowTanggalPrint,$rowTotalRecords,$rowTotalAmount,$rowEmpty]);

        $rowTableHeader    = WriterEntityFactory::createRowFromArray([
            'No','Nomor','Pelanggan','Device','Tagihan','Periode','JTO','Jumlah',
            'Telpon','Alamat','Wilayah', 'Area', 'Kolektor','Deskripsi'
        ], $headerStyle);

        $writer->addRows([$rowTableHeader]);

        $plunck_data = [];
        $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
        foreach ($query->each($dataEachLimit) as $i => $recordModel) {

            $customer   = Customer::find()->where(['id'=>$recordModel->customer_id])->one();
            $enrolment  = Enrolment::find()->where(['customer_id'=>$recordModel->customer_id])->one();

            $villageId  = $customer->village_id;
            $areaId     = $customer->area_id;

            $village    = (!empty($villageId)) ? $customer->village->title : '-';
            $area       = (!empty($areaId)) ? $customer->area->title : '-';
            $collectors = (!empty($areaId)) ? Collector::getListByArea($areaId) : '-';

            $deviceStatus =(!empty($recordModel->device_status)) ?
                    $recordModel->getOneDeviceStatus($recordModel->device_status) : '-';

            $billingStatus =(!empty($recordModel->billing_status)) ?
                    $recordModel->getOneBillingStatus($recordModel->billing_status) : '-';

            $cellValues = [
                ($i+1),
                $enrolment->title,
                $customer->title,
                strip_tags($deviceStatus),
                ($billingStatus=='No') ? 'Belum Dibuat' : strip_tags($billingStatus),
                $recordModel->month_period,
                Yii::$app->formatter->format($recordModel->date_due, 'date'),
                (int)$recordModel->amount,
                $customer->phone_number,
                $customer->address,
                $village,
                $area,
                $collectors,
                $recordModel->description
            ];

            $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
            $plunck_data[]  = $rowDetailCell;
        }

        //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
        $writer->addRows($plunck_data);
        $writer->close();
    }

}