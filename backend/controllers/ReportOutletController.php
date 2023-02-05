<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\Lookup;
use backend\models\Staff;
use backend\models\Customer;
use backend\models\Enrolment;
use backend\models\Outlet;
use backend\models\OutletDetail;
use backend\models\User;

use common\models\ReportOutlet;

use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;



/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportOutletController extends Controller
{

    public function actionOutlet()
    {

        $model              = new ReportOutlet();
        $staffList          = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
        $dateAttributeList  = ['date_issued'=>'Date Issued'];

        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;
            $title          = 'OUTLET';
            $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();

            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $dateFirst      = $model->date_first;
            $dateLast       = $model->date_last;
            $query          = Outlet::find()
                                ->where(['between', $model->option_date,  $dateFirst,  $dateLast])
                                ->orderBy(['date_issued'=>SORT_ASC]);

            if(!empty($model->staff_id)){
                $query->andWhere(['staff_id'=>$model->staff_id]);
            }

            $totalClaim     = ($query->sum('claim')== null) ? '0' : $query->sum('claim');
            $countRecords   = ($query->count()== null) ? '0' : $query->count() ;

            $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');

            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$title.' ('.$rangeDate.')']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print '.Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $rowTotalData       = WriterEntityFactory::createRowFromArray(['Total Data','',$formatter->asDecimal($countRecords)]);
            $rowTotalNilai      = WriterEntityFactory::createRowFromArray(['Total Tagihan','',$formatter->asDecimal($totalClaim)]);

            $writer->addRows([$rowTitle,$rowTanggalPrint,$rowTotalData,$rowTotalNilai,$rowEmpty]);

            $rowTableHeader     = WriterEntityFactory::createRowFromArray([
                'No','Nomor','Pelanggan','Staff','Inisial','Jabatan','Invoice','Periode',
                'Issued','Pasang','Tagihan','Jenis', 'Nilai','Deskripsi','Keterangan',
                'Disimpan Oleh','Tgl Simpan'
            ], $headerStyle);

            if($model->option_detail){
                $rowTableHeader     = WriterEntityFactory::createRowFromArray([
                    'No','Nomor','Pelanggan','Staff','Inisial','Jabatan','Invoice','Periode',
                    'Issued','Pasang','Tagihan','Jenis', 'Nilai','Deskripsi','Keterangan',
                    'Disimpan Oleh','Tgl Simpan',
                    'Pasang','Iuran','Jenis','Status'
                ], $headerStyle);
            }            
            
            $writer->addRows([$rowTableHeader]);

            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $customer   = Customer::find()->where(['id'=>$recordModel->customer_id])->one();
                $enrolment  = Enrolment::find()->where(['customer_id'=>$recordModel->customer_id])->one();
                $staff      = Staff::find()->where(['id'=>$recordModel->staff_id])->one();

                $induk      = OutletDetail::DEVICE_TYPE_MAIN;
                $paralel    = OutletDetail::DEVICE_TYPE_PARALEL;
                
                $countInduk     = OutletDetail::find()->select('device_type')
                                    ->where(['outlet_id'=>$recordModel->id,'device_type'=>$induk])
                                    ->asArray()->count(); 
                $countParalel   = OutletDetail::find()->select('device_type')
                                    ->where(['outlet_id'=>$recordModel->id,'device_type'=>$paralel])
                                    ->asArray()->count();                   
                
                $infoInduk      = ($countInduk > 0) ? $countInduk.' Induk' : '';
                $infoParalel    = ($countParalel > 0) ? ' | '.$countParalel.' Paralel' : '';
                $infoOutlet     = $infoInduk.$infoParalel;

                $cellValues = [
                    ($i+1),
                    $enrolment->title,
                    $customer->title,
                    $staff->title,
                    $staff->initial,
                    ($staff->employment_id) != null ? $staff->employment->title :'',
                    $recordModel->invoice,
                    $recordModel->month_period,
                    Yii::$app->formatter->asDate($recordModel->date_issued,'dd/MM/yy'),
                    Yii::$app->formatter->asDate($recordModel->date_assembly,'dd/MM/yy'),
                    
                    strip_tags($recordModel->getOneBillingStatus($recordModel->billing_status)),
                    strip_tags($recordModel->getOneAssemblyType($recordModel->assembly_type)),
                    
                    (int)$recordModel->claim,
                    $recordModel->description,
                    $infoOutlet,
                    ($recordModel->created_by!=null) ? User::getName($recordModel->created_by):'',
                    Yii::$app->formatter->asDate($recordModel->created_at,'dd/MM/yy')
                ];

                if($model->option_detail){

                    $queryDetails = OutletDetail::find()->where(['outlet_id'=>$recordModel->id]);
                    foreach ($queryDetails->each($dataEachLimit) as $j => $queryDetailModel) {

                        $outletDetailDeviceType = $queryDetailModel->getOneDeviceType($queryDetailModel->device_type);
                        $outletDetailDeviceStatus = $queryDetailModel->getOneDeviceStatus($queryDetailModel->device_status);

                        $cellValues = [
                            ($i+1),
                            $enrolment->title,
                            $customer->title,
                            $staff->title,
                            $staff->initial,
                            ($staff->employment_id) != null ? $staff->employment->title :'',
                            $recordModel->invoice,
                            $recordModel->month_period,
                            Yii::$app->formatter->asDate($recordModel->date_issued,'dd/MM/yy'),
                            Yii::$app->formatter->asDate($recordModel->date_assembly,'dd/MM/yy'),

                            strip_tags($recordModel->getOneBillingStatus($recordModel->billing_status)),
                            strip_tags($recordModel->getOneAssemblyType($recordModel->assembly_type)),

                            (int)$recordModel->claim,
                            $recordModel->description,
                            $infoOutlet,
                            ($recordModel->created_by!=null) ? User::getName($recordModel->created_by):'',
                            Yii::$app->formatter->asDate($recordModel->created_at,'dd/MM/yy'),
                            
                            (int)$queryDetailModel->assembly_cost,
                            (int)$queryDetailModel->monthly_bill,
                            strip_tags($outletDetailDeviceType),
                            strip_tags($outletDetailDeviceStatus)
                        ];


                        $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                        $plunck_data[]  = $rowDetailCell;
                    }
                }                
                else{
                    $rowMasterCell  = WriterEntityFactory::createRowFromArray($cellValues);
                    $writer->addRows([$rowMasterCell]);                
                }
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data);
            $writer->addRows([$rowEmpty]);

//            if($model->option_detail){
//
//                $rowJumlahOnTime        = WriterEntityFactory::createRowFromArray(['Jumlah Ontime','','',$formatter->asDecimal($ontime)]);
//                $rowJumlahOverdue       = WriterEntityFactory::createRowFromArray(['Jumlah Overdue','','',$formatter->asDecimal($overdue)]);
//                $rowTotalPenaltyPaid    = WriterEntityFactory::createRowFromArray(['Total Penalti Dibayar ('.$countPenaltyPaid.')','','',$formatter->asDecimal($penaltyPaid)]);
//                $rowTotalPenaltyUnpaid  = WriterEntityFactory::createRowFromArray(['Total Penalti Hutang ('.$countPenaltyUnpaid.')','','',$formatter->asDecimal($penaltyUnpaid)]);
//
//                $writer->addRows([$rowJumlahOnTime,$rowJumlahOverdue,$rowTotalPenaltyPaid,$rowTotalPenaltyUnpaid]);
//
//            }

            $writer->close();

        }
        else {
            return $this->render('_form_outlet', [
                'model' => $model,
                'dateAttributeList'=>$dateAttributeList,
                'staffList'=>$staffList,
            ]);
        }
    }


    public function actionPeriod($month,$attribute,$value)
    {

        $formatter      = \Yii::$app->formatter;
        $title          = 'Outlet';
        $filename       = $title. ' '.Lookup::getTitleById($value).' '.$month;

        $headerStyle    = ReportCloud::getHeaderStyle();
        $rowStyle       = ReportCloud::getRowStyle();

        $writer         = ReportCloud::getWriterFactory();
        $writer->openToBrowser($filename.ReportCloud::getFileExtension());
        $writer->getCurrentSheet();
        $writer->setDefaultRowStyle($rowStyle);

        $query          = OutletDetail::find()->where(['tx_receivable.month_period'=>$month]);
        $query->andWhere([$attribute=>$value]);
        $query->joinWith('receivable');

        $countRecords       = ($query->count()== null) ? '0' : $query->count() ;
        $totalPenalty       = ($query->sum('tx_receivable_detail.penalty') == null) ? '0' : $query->sum('tx_receivable_detail.penalty');
        $totalClaim         = ($query->sum('tx_receivable_detail.claim')==null) ? '0' : $query->sum('tx_receivable_detail.claim');
        $totalTotal         = ($query->sum('tx_receivable_detail.total')==null) ? '0' : $query->sum('tx_receivable_detail.total');
        $totalClaim       = ($query->sum('tx_receivable_detail.claim')==null) ? '0' : $query->sum('tx_receivable_detail.claim');

        $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
        $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'',' ('.$month.')']);
        $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print'  ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
        $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
        $rowTotalPenalty    = WriterEntityFactory::createRowFromArray(['Total Penalty'  ,'',$formatter->asDecimal($totalPenalty)]);
        $rowTotalClaim      = WriterEntityFactory::createRowFromArray(['Total Claim'    ,'',$formatter->asDecimal($totalClaim)]);
        $rowTotalPenClaim   = WriterEntityFactory::createRowFromArray(['Total (Penalty+Claim)','',$formatter->asDecimal($totalTotal)]);

        $rowTotalPayment    = WriterEntityFactory::createRowFromArray(['Total Payment','',$formatter->asDecimal($totalClaim)]);
        $writer->addRows([
            $rowTitle,$rowTanggalPrint,$rowTotalRecords,
            $rowTotalPenalty,$rowTotalClaim, $rowTotalPenClaim,
            $rowTotalPayment,$rowEmpty
        ]);

        $rowTableHeader    = WriterEntityFactory::createRowFromArray([
            'No','Nomor','Pelanggan','Billing','Tgl Issued','Tgl Pasang',
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
            $villageId  = $customer->village_id;
            $areaId     = $customer->area_id;

            $village    = (!empty($villageId)) ? $customer->village->title : '-';
            $area       = (!empty($areaId)) ? $customer->area->title : '-';

            $billingType = $recordModel->billing->getOneBillingType($recordModel->billing->billing_type);

            $penalty    = (!empty($recordModel->penalty)) ?$recordModel->penalty:'0';

            $cellValues = [
                ($i+1),
                '['.$enrolment->title.']',
                $customer->title,
                $billingType,
                Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                Yii::$app->formatter->format($recordModel->date_assembly, 'date'),
                (int)$penalty,
                (int)$recordModel->claim,
                (int)$recordModel->claim,
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

