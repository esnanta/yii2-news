<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

use backend\models\Lookup;
use backend\models\Customer;
use backend\models\Enrolment;
use backend\models\Billing;
use backend\models\Collector;

use common\models\ReportBilling;
use common\helper\ReportCloud;
use common\helper\Helper as Helper;
use common\helper\CacheCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;



/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportBillingController extends Controller
{

    public function actionBilling()
    {

        $model              = new ReportBilling;
        $billingTypeList    = Billing::getArrayBillingType();
        $paymentStatusList  = Billing::getArrayPaymentStatus();
        $dateAttributeList  = ['date_due'=>'Date Due', 'date_issued'=>'Date Issued'];

        $paidOffStatus      = Billing::PAYMENT_STATUS_PAID;
        
        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;
            $title          = 'BILLING';
            $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');
            $dateFirst      = Helper::setDateToNoon($model->date_first);
            $dateLast       = Helper::setDateToNoon($model->date_last);
            $query          = Billing::find()
                                ->where(['between', $model->option_date,  $dateFirst,  $dateLast])
                                ->orderBy(['date_due'=>SORT_ASC]);

            if(!empty($model->billing_type)){
                $query->andWhere(['billing_type'=>$model->billing_type]);
            }
            if(!empty($model->payment_status)){
                $query->andWhere(['payment_status'=>$model->payment_status]);
            }

            //NILAI AWAL ADALAH 0, DIUBAH DI LINE BERIKUT
            //IF(!$model->option_detail)
            $totalAmount    = 0;
            $countRecords   = 0;

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();


            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');
            
            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$title.' ('.$rangeDate.')']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print '.Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $writer->addRows([$rowTitle,$rowTanggalPrint,$rowEmpty]);

            if(!$model->option_detail){

                $totalAmount        = ($query->sum('amount')== null) ? '0' : $query->sum('amount');
                $countRecords       = ($query->count()== null) ? '0' : $query->count() ;

                $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records','',$formatter->asDecimal($countRecords)]);
                $rowTotalAmount     = WriterEntityFactory::createRowFromArray(['Total Amount','',$formatter->asDecimal($totalAmount)]);
                
                $writer->addRows([$rowTotalRecords,$rowTotalAmount,$rowEmpty]);

            }

            $rowTableHeader     = WriterEntityFactory::createRowFromArray([
                'No','Nomor','Pelanggan','Jenis','Periode','Status','JTO','Overdue','Jumlah',
                'Telpon','Alamat','Wilayah', 'Area', 'Kolektor','Lokasi',
                'Siklus','Periode Lain','Overdue Terlama',
            ], $headerStyle);

            $writer->addRows([$rowTableHeader]);

            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $customer   = Customer::find()->where(['id'=>$recordModel->customer_id])->one();
                $enrolment  = Enrolment::find()->where(['customer_id'=>$recordModel->customer_id])->one();

                $villageId      = $customer->village_id;
                $areaId         = $customer->area_id;
                $networkId      = $enrolment->network_id;

                $village    = (!empty($villageId)) ? $customer->village->title : '-';
                $area       = (!empty($areaId)) ? $customer->area->title : '-';
                $collectors = (!empty($areaId)) ? Collector::getListByArea($areaId): '-';
                $network    = (!empty($networkId)) ? $enrolment->network->title : '-';

                $billingType =(!empty($recordModel->billing_type)) ?
                        $recordModel->getOneBillingType($recordModel->billing_type) : '-';

                $paymentStatus =(!empty($recordModel->payment_status)) ?
                        $recordModel->getOnePaymentStatus($recordModel->payment_status) : '-';

                $checkSiklus = '';
                if(empty($enrolment->billing_cycle)){
                    $checkSiklus = 'Mohon Update Siklus';
                }
                elseif(strlen($enrolment->billing_cycle) < 2){
                    $checkSiklus = 'Siklus harus 2 digit. Mohon Update.';
                }

                $cellValues = [
                    ($i+1), 
                    $enrolment->title,
                    $customer->title,
                    strip_tags($billingType),
                    $recordModel->month_period,
                    strip_tags($paymentStatus),
                    Yii::$app->formatter->format($recordModel->date_due, 'date'),
                    Helper::getOverdue(time(), $recordModel->date_due),
                    (int)$recordModel->amount,
                    $customer->phone_number,
                    $customer->address,
                    $village,
                    $area,
                    $collectors,
                    $network,
                    '['.$enrolment->billing_cycle.'/bln]',
                    '-',
                    '-',
                    $checkSiklus
                ];

                if($model->option_detail){
                    $periodeLainnya = '';
                    $overDueTerlama = '';

                    $queryDetails = Billing::find()
                        ->where(['customer_id'=>$recordModel->customer_id])
                        ->andWhere(['<>', 'id', $recordModel->id])
                        ->andWhere(['<>', 'payment_status', $paidOffStatus])
                        ->orderBy(['created_at' => SORT_DESC]);

                    foreach($queryDetails->each($dataEachLimit) as $j => $queryDetailModel){

                        $tmpBillingType =(!empty($queryDetailModel->billing_type)) ?
                                $queryDetailModel->getOneBillingType($queryDetailModel->billing_type) : '-';
                                
                        $billingType    = str_replace('Tagihan Iuran', 'Ang', $tmpBillingType);
                        $periodeLainnya = $periodeLainnya.' '.$billingType.' '.$queryDetailModel->month_period.' | ';

                        $overDueTerlama = Helper::getOverdue(time(), $queryDetailModel->date_due);

                        $totalAmount    = $totalAmount+$queryDetailModel->amount;
                        $countRecords   = $countRecords+1;

                    }

                    $cellValues = [
                        ($i+1), 
                        $enrolment->title,
                        $customer->title,
                        strip_tags($billingType),
                        $recordModel->month_period,
                        strip_tags($paymentStatus),
                        Yii::$app->formatter->format($recordModel->date_due, 'date'),
                        Helper::getOverdue(time(), $recordModel->date_due),
                        (int)$recordModel->amount,
                        $customer->phone_number,
                        $customer->address,
                        $village,
                        $area,
                        $collectors,
                        $network,
                        '['.$enrolment->billing_cycle.'/bln]',
                        strip_tags($periodeLainnya),
                        $overDueTerlama,
                        $checkSiklus
                    ];

                }

                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data); 
            $writer->addRows([$rowEmpty]);

            if($model->option_detail){
                
                $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records','',$formatter->asDecimal($countRecords)]);
                $rowTotalAmount     = WriterEntityFactory::createRowFromArray(['Total Amount','',$formatter->asDecimal($totalAmount)]);
                $rowTotalSummary    = WriterEntityFactory::createRowFromArray(['NB : Total sudah termasuk periode lainnya.']);

                $writer->addRows([$rowTotalRecords,$rowTotalAmount,$rowTotalSummary]); 
            }

            $writer->close();

        }
        else {
            return $this->render('_form_billing', [
                'model' => $model,
                'dateAttributeList'=>$dateAttributeList,
                'billingTypeList'=>$billingTypeList,
                'paymentStatusList'=>$paymentStatusList
            ]);
        }
    }

    public function actionPeriod($month,$attribute,$value)
    {

        $formatter      = \Yii::$app->formatter;
        $title          = 'BILLING';
        $filename       = $title. ' '.Lookup::getTitleById($value).' '.$month;
        
        $headerStyle    = ReportCloud::getHeaderStyle();
        $rowStyle       = ReportCloud::getRowStyle();

        $writer = ReportCloud::getWriterFactory();
        $writer->openToBrowser($filename.ReportCloud::getFileExtension());
        $writer->getCurrentSheet();
        $writer->setDefaultRowStyle($rowStyle);        
        
        $query          = Billing::find()->where(['month_period'=>$month]);
        $query->andWhere([$attribute=>$value]);

        $totalAmount        = ($query->sum('amount')== null) ? '0' : $query->sum('amount');
        $countRecords       = ($query->count()== null) ? '0' : $query->count() ;
       
        $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
        $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'',' ('.$month.')']);
        $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print'  ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
        $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
        $rowTotalAmount     = WriterEntityFactory::createRowFromArray(['Total Amount'   ,'',$formatter->asDecimal($totalAmount)]);
        $writer->addRows([$rowTitle,$rowTanggalPrint,$rowTotalRecords,$rowTotalAmount,$rowEmpty]);

        $rowTableHeader    = WriterEntityFactory::createRowFromArray([
            'No','Nomor','Pelanggan','Jenis','Status','Periode','JTO','Jumlah',
            'Telpon','Alamat','Wilayah', 'Area', 'Kolektor'
        ], $headerStyle);

        $writer->addRows([$rowTableHeader]);

        $plunck_data = [];
        $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
        foreach ($query->each($dataEachLimit) as $i => $recordModel) {

            $customer   = Customer::find()->where(['id'=>$recordModel->customer_id])->one();
            $villageId  = $customer->village_id;
            $areaId     = $customer->area_id;

            $village    = (!empty($villageId)) ? $customer->village->title : '-';
            $area       = (!empty($areaId)) ? $customer->area->title : '-';
            $collectors = (!empty($areaId)) ? Collector::getListByArea($areaId): '-';
            //$network    = (!empty($networkId)) ? $enrolment->network->title : '-';            
            
            $billingType =(!empty($recordModel->billing_type)) ?
                    $recordModel->getOneBillingType($recordModel->billing_type) : '-';

            $paymentStatus =(!empty($recordModel->payment_status)) ?
                    $recordModel->getOnePaymentStatus($recordModel->payment_status) : '-';

            $cellValues = [
                ($i+1), 
                $recordModel->enrolment->title,
                $customer->title,
                strip_tags($billingType),
                strip_tags($paymentStatus),
                $recordModel->month_period,
                Yii::$app->formatter->format($recordModel->date_due, 'date'),
                (int)$recordModel->amount,
                $customer->phone_number,
                $customer->address,
                $village,
                $area,
                $collectors
            ];

            $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
            $plunck_data[]  = $rowDetailCell;

        }

        //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
        $writer->addRows($plunck_data); 
        $writer->close();
    }


}

