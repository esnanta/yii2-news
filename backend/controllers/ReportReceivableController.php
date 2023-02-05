<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\Lookup;
use backend\models\Staff;
use backend\models\Customer;
use backend\models\Enrolment;
use backend\models\Billing;
use backend\models\Receivable;
use backend\models\ReceivableDetail;
use backend\models\User;

use common\models\ReportReceivable;

use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;



/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportReceivableController extends Controller
{

    public function actionReceivable()
    {

        $model              = new ReportReceivable();
        $staffList          = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
        $dateAttributeList  = ['date_issued'=>'Date Issued'];


        $ontime             = 0;
        $overdue            = 0;
        $penaltyPaid        = 0;
        $countPenaltyPaid   = 0;
        $penaltyUnpaid      = 0;
        $countPenaltyUnpaid = 0;

        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;
            $title          = 'RECEIVABLE';
            $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();

            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $dateFirst      = $model->date_first;
            $dateLast       = $model->date_last;
            $query          = Receivable::find()
                                ->where(['between', $model->option_date,  $dateFirst,  $dateLast])
                                ->orderBy(['date_issued'=>SORT_ASC]);
            
            if(!empty($model->staff_id)){
                $query->andWhere(['staff_id'=>$model->staff_id]);
            }

            $totalPayment   = ($query->sum('payment')== null) ? '0' : $query->sum('payment');
            $countRecords   = ($query->count()== null) ? '0' : $query->count() ;

            $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');
            
            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$title.' ('.$rangeDate.')']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print '.Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $rowTotalData       = WriterEntityFactory::createRowFromArray(['Total Data','',$formatter->asDecimal($countRecords)]);
            $rowTotalNilai      = WriterEntityFactory::createRowFromArray(['Total Penerimaan','',$formatter->asDecimal($totalPayment)]);

            $writer->addRows([$rowTitle,$rowTanggalPrint,$rowTotalData,$rowTotalNilai,$rowEmpty]);

            $rowTableHeader     = WriterEntityFactory::createRowFromArray([
                'No','Nomor','Pelanggan','Staff','Jabatan','Invoice','Periode','Issued',
                'Tagihan','Tambahan', 'Penalty','Total','Diskon','Pembayaran','Balance',
                'Siklus','Overdue','Jenis Tagihan','Disimpan Oleh','Tgl Simpan'
            ], $headerStyle);

            $writer->addRows([$rowTableHeader]);

            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $customer   = Customer::find()->where(['id'=>$recordModel->customer_id])->one();
                $enrolment  = Enrolment::find()->where(['customer_id'=>$recordModel->customer_id])->one();
                $staff      = Staff::find()->where(['id'=>$recordModel->staff_id])->one();

                $checkSiklus = '';
                if(empty($enrolment->billing_cycle)){
                    $checkSiklus = 'Mohon Update Siklus';
                }
                elseif(strlen($enrolment->billing_cycle) < 2){
                    $checkSiklus = 'Siklus harus 2 digit. Mohon Update.';
                }

                $infoTagihan = '';
                $infoOverdue = '';
                $queryDetails = ReceivableDetail::find()->where(['receivable_id'=>$recordModel->id]);
                foreach ($queryDetails->each($dataEachLimit) as $j => $queryDetailModel) {

                    $billing    = Billing::find()
                                    ->where(['id'=>$queryDetailModel->billing_id])
                                    ->orderBy(['billing_type'=>SORT_ASC])
                                    ->one();

                    $tmpBillingType =(!empty($billing->billing_type)) ?
                            $billing->getOneBillingType($billing->billing_type) : '-';

                    $billingType    = str_replace('Tagihan Iuran', 'Ang', $tmpBillingType);
                    $infoTagihan    = $infoTagihan.'|'.$billingType.' '.$billing->month_period;

                    $overdueStatus =(!empty($queryDetailModel->accuracy_status)) ?
                            $queryDetailModel->getOneAccuracyStatus($queryDetailModel->accuracy_status) : '-';

                    $infoOverdue = $infoOverdue.'| '.$overdueStatus.' ('.$queryDetailModel->overdue.')';

                }

                $cellValues = [
                    ($i+1), 
                    $enrolment->title,
                    $customer->title,
                    $staff->title,
                    ($staff->employment_id) != null ? $staff->employment->title :'',
                    $recordModel->invoice,
                    $recordModel->month_period,
                    Yii::$app->formatter->asDate($recordModel->date_issued,'dd/MM/yy'),
                    (int)$recordModel->claim,
                    (int)$recordModel->surcharge,
                    ($model->option_detail) ? '' : (int)$recordModel->penalty,
                    (int)$recordModel->total,
                    (int)$recordModel->discount,
                    (int)$recordModel->payment,
                    (int)$recordModel->balance,
                    '['.$enrolment->billing_cycle.'/bln]',
                    strip_tags($infoOverdue),
                    strip_tags($infoTagihan),
                    ($recordModel->created_by!=null) ? User::getName($recordModel->created_by):'',
                    Yii::$app->formatter->asDate($recordModel->created_at,'dd/MM/yy'),
                    '',
                    '',
                    '',
                    $checkSiklus
                ];

                $rowMasterCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $writer->addRows([$rowMasterCell]);

                if($model->option_detail){

                    foreach ($queryDetails->each($dataEachLimit) as $j => $queryDetailModel) {

                        if ($queryDetailModel->overdue > 0){
                            $overdue    = $overdue + 1;
                        }
                        else{
                            $ontime     = $ontime+1;
                        }

                        $queryDetailModel->penalty = (empty($queryDetailModel->penalty)) ? '0' : $queryDetailModel->penalty;

                        if ($queryDetailModel->overdue > 0 && $queryDetailModel->penalty > 0){
                            $penaltyPaid    = $penaltyPaid + $queryDetailModel->penalty;
                            $countPenaltyPaid = $countPenaltyPaid + 1;
                        }
                        else if ($queryDetailModel->overdue > 0 && $queryDetailModel->penalty <= 0){
                            $penaltyUnpaid  = $penaltyUnpaid + 10000;
                            $countPenaltyUnpaid = $countPenaltyUnpaid + 1;
                        }
                        
                        $billingType    = $recordModel->billing->getOneBillingType($recordModel->billing->billing_type);
                        $overdueStatus  = $recordModel->getOneAccuracyStatus($recordModel->accuracy_status);

                        $cellValues = [
                            '', 
                            '',
                            '',
                            '',
                            strip_tags($billingType),
                            'Claim',
                            (int)$queryDetailModel->claim,
                            '',
                            '',
                            (int)$queryDetailModel->penalty,
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Due '.Yii::$app->formatter->asDate($queryDetailModel->date_due,'dd/MM/yy'),
                            '',
                            '',
                            strip_tags($overdueStatus),
                            (int)$queryDetailModel->overdue,
                            ($queryDetailModel->overdue > 0 && $queryDetailModel->penalty <= 0) ? '(-) 10000' : '',
                        ];


                        $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                        $plunck_data[]  = $rowDetailCell;
                    }
                }
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data); 
            $writer->addRows([$rowEmpty]);

            if($model->option_detail){
                
                $rowJumlahOnTime        = WriterEntityFactory::createRowFromArray(['Jumlah Ontime','','',$formatter->asDecimal($ontime)]);
                $rowJumlahOverdue       = WriterEntityFactory::createRowFromArray(['Jumlah Overdue','','',$formatter->asDecimal($overdue)]);
                $rowTotalPenaltyPaid    = WriterEntityFactory::createRowFromArray(['Total Penalti Dibayar ('.$countPenaltyPaid.')','','',$formatter->asDecimal($penaltyPaid)]);
                $rowTotalPenaltyUnpaid  = WriterEntityFactory::createRowFromArray(['Total Penalti Hutang ('.$countPenaltyUnpaid.')','','',$formatter->asDecimal($penaltyUnpaid)]);

                $writer->addRows([$rowJumlahOnTime,$rowJumlahOverdue,$rowTotalPenaltyPaid,$rowTotalPenaltyUnpaid]);                 

            }

            $writer->close();

        }
        else {
            return $this->render('_form_receivable', [
                'model' => $model,
                'dateAttributeList'=>$dateAttributeList,
                'staffList'=>$staffList,
            ]);
        }
    }


    public function actionPeriod($month,$attribute,$value)
    {

        $formatter      = \Yii::$app->formatter;
        $title          = 'Receivable';
        $filename       = $title. ' '.Lookup::getTitleById($value).' '.$month;
        
        $headerStyle    = ReportCloud::getHeaderStyle();
        $rowStyle       = ReportCloud::getRowStyle();

        $writer         = ReportCloud::getWriterFactory();
        $writer->openToBrowser($filename.ReportCloud::getFileExtension());
        $writer->getCurrentSheet();
        $writer->setDefaultRowStyle($rowStyle);         

        $query          = ReceivableDetail::find()->where(['tx_receivable.month_period'=>$month]);
        $query->andWhere([$attribute=>$value]);
        $query->joinWith('receivable');

        $countRecords       = ($query->count()== null) ? '0' : $query->count() ;
        $totalPenalty       = ($query->sum('tx_receivable_detail.penalty') == null) ? '0' : $query->sum('tx_receivable_detail.penalty');
        $totalClaim         = ($query->sum('tx_receivable_detail.claim')==null) ? '0' : $query->sum('tx_receivable_detail.claim');
        $totalTotal         = ($query->sum('tx_receivable_detail.total')==null) ? '0' : $query->sum('tx_receivable_detail.total');
        $totalPayment       = ($query->sum('tx_receivable_detail.payment')==null) ? '0' : $query->sum('tx_receivable_detail.payment');

        $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
        $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'',' ('.$month.')']);
        $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print'  ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
        $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
        $rowTotalPenalty    = WriterEntityFactory::createRowFromArray(['Total Penalty'  ,'',$formatter->asDecimal($totalPenalty)]);
        $rowTotalClaim      = WriterEntityFactory::createRowFromArray(['Total Claim'    ,'',$formatter->asDecimal($totalClaim)]);
        $rowTotalPenClaim   = WriterEntityFactory::createRowFromArray(['Total (Penalty+Claim)','',$formatter->asDecimal($totalTotal)]);

        $rowTotalPayment    = WriterEntityFactory::createRowFromArray(['Total Payment','',$formatter->asDecimal($totalPayment)]);
        $writer->addRows([
            $rowTitle,$rowTanggalPrint,$rowTotalRecords,
            $rowTotalPenalty,$rowTotalClaim, $rowTotalPenClaim,
            $rowTotalPayment,$rowEmpty
        ]);

        $rowTableHeader    = WriterEntityFactory::createRowFromArray([
            'No','Nomor','Pelanggan','Billing','Tgl Issued','Tgl JTO','Status',
            'Penalty','Claim', 'Total','Payment',
            'Telpon','Alamat','Desa', 'Area', 'Staff'
        ], $headerStyle);
        $writer->addRows([$rowTableHeader]);


        $plunck_data = [];
        $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
        foreach ($query->each($dataEachLimit) as $i => $recordModel) {

            $customer   = Customer::find()->where(['id'=>$recordModel->receivable->customer_id])->one();
            $enrolment  = Enrolment::find()->where(['customer_id'=>$customer->id])->one();

            $staffTitle = Staff::getName($recordModel->receivable->staff_id);
            $village    = (!empty($customer->village_id)) ? $customer->village->title : '-';
            $area       = (!empty($customer->area_id)) ? $customer->area->title : '-';

            $billingType    = $recordModel->billing->getOneBillingType($recordModel->billing->billing_type);
            $overdueStatus  = $recordModel->getOneAccuracyStatus($recordModel->accuracy_status);
   
            $penalty    = (!empty($recordModel->penalty)) ?$recordModel->penalty:'0';

            $cellValues = [
                ($i+1), 
                '['.$enrolment->title.']',
                $customer->title,
                strip_tags($billingType),
                Yii::$app->formatter->format($recordModel->receivable->date_issued, 'date'),
                Yii::$app->formatter->format($recordModel->date_due, 'date'),
                strip_tags($overdueStatus),
                (int)$penalty,
                (int)$recordModel->claim,
                (int)$recordModel->payment,
                $customer->phone_number,
                $customer->address,
                $village,
                $area,
                $staffTitle
            ];

            $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
            $plunck_data[]  = $rowDetailCell;

        }

        //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
        $writer->addRows($plunck_data); 
        $writer->close();

    }
  

}

