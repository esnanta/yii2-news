<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

use common\models\ReportSummary;
use common\helper\CacheCloud;

use backend\models\Profile;
use backend\models\AccountReceivableDetail;
use backend\models\AccountPayableDetail;
use backend\models\Outlet;
use backend\models\Billing;
use backend\models\Receivable;
use backend\models\ReceivableDetail;
use backend\models\Note;

use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;




/**
 * Site controller
 */
class CashController extends Controller
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    private function getWriterFactory(){
        //return WriterEntityFactory::createODSWriter();
        return WriterEntityFactory::createXLSXWriter();
    }
    
    private function getFileExtension(){
        //return '.ods';
        return '.xlsx';
    }

    public function actionIndex()
    {
        
        $formatter      = \Yii::$app->formatter;
        $currDate       = date('d',time());
        $currMonth      = date('m',time());
        $currYear       = date('Y',time());
        
        $dataEachLimit      = Yii::$app->params['Data_Each_Limit'];

        $cacheCloud         = new CacheCloud();
        
        $dateFirst      = strtotime($currYear.'-'.$currMonth.'-'.$currDate.' 00:00:01');
        $dateLast       = strtotime($currYear.'-'.$currMonth.'-'.$currDate.' 23:59:59');

        $typeSummaryList = ReportSummary::getArrayOptionType();
        $dateSummaryList = ReportSummary::getArrayOptionDate();
        
        $modelReportSummary = new ReportSummary();
        $modelReportSummary->option_date = ReportSummary::OPTION_DATE_ISSUED;//DEFAULT
        $modelReportSummary->date_first = $dateFirst;
        $modelReportSummary->date_last  = $dateLast;        
        
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        
        $queryOutlet  = Outlet::find()
            ->where(['between', $modelReportSummary->option_date,  $dateFirst,  $dateLast]);

        $queryReceivable = Receivable::find()
            ->where(['between', $modelReportSummary->option_date,  $dateFirst,  $dateLast]);
        
        $queryAccountReceivable = AccountReceivableDetail::find()
            ->where(['between', 'tx_account_receivable.'.$modelReportSummary->option_date,  $dateFirst,  $dateLast]);
        $queryAccountReceivable->joinWith(['accountReceivable']);
        
        $queryAccountPayable = AccountPayableDetail::find()
            ->where(['between', 'tx_account_payable.'.$modelReportSummary->option_date,  $dateFirst,  $dateLast]);        
        $queryAccountPayable->joinWith(['accountPayable']);
        
        //NILAI
        $totalOutlet                = ($queryOutlet->sum('claim') > 0) ? $queryOutlet->sum('claim'): 0; 
        //INCOME    
        $totalAccountReceivable     = ($queryAccountReceivable->sum('amount') > 0) ? $queryAccountReceivable->sum('amount') : 0;  
        $totalReceivable            = ($queryReceivable->sum('payment') > 0) ? $queryReceivable->sum('payment') : 0;  
        $totalIncome                = $totalAccountReceivable+$totalReceivable; 
        //OUTCOME
        $totalAccountPayable        = ($queryAccountPayable->sum('amount') > 0) ? $queryAccountPayable->sum('amount') : 0;    
        $totalOutcome               = $totalAccountPayable;    
        $totalSummary               = $totalIncome - $totalOutcome;        

        $countOutlet                = ($queryOutlet->count()==null) ? '0' : $queryOutlet->count(); 
        $countAccountReceivable     = ($queryAccountReceivable->count()==null) ? '0' : $queryAccountReceivable->count();   
        $countAccountPayable        = ($queryAccountPayable->count()==null) ? '0' : $queryAccountPayable->count();   
        $countReceivable            = ($queryReceivable->count()==null) ? '0' : $queryReceivable->count();  
        $countIncome                = $countAccountReceivable+$countReceivable; 
        $countOutcome               = $countAccountPayable;    

        
        if ($modelReportSummary->load(Yii::$app->request->post())) {
            
            $dateFirst  = strtotime(date('Y',$modelReportSummary->date_first).'-'.date('m',$modelReportSummary->date_first).'-'.date('d',$modelReportSummary->date_first).' 11:00:01');
            $dateLast   = strtotime(date('Y',$modelReportSummary->date_last).'-'.date('m',$modelReportSummary->date_last).'-'.date('d',$modelReportSummary->date_last).' 12:59:59');            
            
            $queryOutlet = Outlet::find()
                ->where(['between', $modelReportSummary->option_date, $dateFirst, $dateLast])
                ->orderBy(['date_issued'=>SORT_ASC]);
            
            $queryReceivable = Receivable::find()
                ->where(['between', $modelReportSummary->option_date,  $dateFirst,  $dateLast])
                ->orderBy(['date_issued'=>SORT_ASC]);

            $queryAccountReceivable = AccountReceivableDetail::find()
                ->where(['between', 'tx_account_receivable.'.$modelReportSummary->option_date,  $dateFirst,  $dateLast])
                ->orderBy(['tx_account_receivable.date_issued'=>SORT_ASC]);
            $queryAccountReceivable->joinWith(['accountReceivable']);
            
            $queryAccountPayable = AccountPayableDetail::find()
                ->where(['between', 'tx_account_payable.'.$modelReportSummary->option_date,  $dateFirst,  $dateLast])
                ->orderBy(['tx_account_payable.date_issued'=>SORT_ASC]);
            $queryAccountPayable->joinWith(['accountPayable']);            
            
            $queryNote = Note::find()
                ->where(['between', $modelReportSummary->option_date, $dateFirst, $dateLast])
                ->orderBy(['date_issued'=>SORT_ASC]);       
            $queryNote->joinWith(['noteType']);  
            
            //NILAI
            $totalOutlet                = ($queryOutlet->sum('claim') > 0) ? $queryOutlet->sum('claim') : 0;             
            //INCOME
            $totalAccountReceivable     = ($queryAccountReceivable->sum('amount') > 0) ? $queryAccountReceivable->sum('amount') : 0;  
            $totalReceivable            = ($queryReceivable->sum('payment') > 0) ? $queryReceivable->sum('payment') : 0;  
            $totalIncome                = $totalAccountReceivable+$totalReceivable; 
            //OUTCOME
            $totalAccountPayable        = ($queryAccountPayable->sum('amount') > 0) ? $queryAccountPayable->sum('amount') : 0;    
            $totalOutcome               = $totalAccountPayable;     
            $totalSummary               = $totalIncome - $totalOutcome;            
            
            $countOutlet                = ($queryOutlet->count()==null) ? '0' : $queryOutlet->count(); 
            $countNote                  = ($queryNote->count()==null) ? '0' : $queryNote->count(); 
            $countAccountReceivable     = ($queryAccountReceivable->count()==null) ? '0' : $queryAccountReceivable->count();     
            $countReceivable            = ($queryReceivable->count()==null) ? '0' : $queryReceivable->count();  
            $countIncome                = $countAccountReceivable+$countReceivable; 
            $countOutcome               = ($queryAccountPayable->count()==null) ? '0' : $queryAccountPayable->count();                

            if($modelReportSummary->option_type == ReportSummary::OPTION_TYPE_EXPORT){
                
                //BACA INI BRAY
                //https://github.com/box/spout/blob/master/UPGRADE-3.0.md

                $filename = 'CASH FLOW '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');
                $border = (new BorderBuilder())
                    ->setBorderTop(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
                    ->setBorderBottom(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
                    ->setBorderLeft(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)
                    ->setBorderRight(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_NONE)

                    ->build();

                $headerStyle = (new StyleBuilder())
                    ->setBackgroundColor(Color::LIGHT_BLUE)
                    ->setBorder($border)
                    ->setShouldWrapText(false)
                    ->build();                
                
                $titleStyle = (new StyleBuilder())
                    ->setBorder($border)
                    ->setFontBold()
                    ->setFontUnderline()
                    ->setShouldWrapText(false)
                    ->build();                 
                
                $rowStyle = (new StyleBuilder())
                    ->setBorder($border)
                    ->setShouldWrapText(false)
                    ->build();                 
                
                $writer = $this->getWriterFactory();
                $writer->openToBrowser($filename.$this->getFileExtension());
                $writer->getCurrentSheet();            
                $writer->setDefaultRowStyle($rowStyle);
                
                $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');
                $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);

                $rowKasHarian       = WriterEntityFactory::createRowFromArray(['Kas Harian ('.$rangeDate.')']);
                $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print '.Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss'), '','','','','','','','','','']);
                
                $writer->addRows([$rowKasHarian,$rowTanggalPrint,$rowEmpty]);
                
                /*
                ****************************************************************
                ****************************************************************
                OUTLET  
                */

                $rowInfoPasang      = WriterEntityFactory::createRowFromArray(['PEMASANGAN OUTLET ('.$formatter->asDecimal($totalOutlet).')']);
                $rowHeaderOutlet    = WriterEntityFactory::createRowFromArray(['No','Title','Kode','Nomor','Nama','','Tagihan','Issued','','','','','','Amount','-','-','Description'], $headerStyle);
                $writer->addRows([$rowInfoPasang,$rowHeaderOutlet]);

                $plunckDataOutlet = [];
                foreach ($queryOutlet->each($dataEachLimit) as $i=>$outletModel) {
                    
                    $billingStatus =(!empty($outletModel->billing_status)) ? 
                        $outletModel->getOneBillingStatus($outletModel->billing_status)  : '-';      
                    
                    $cellValues = [
                        ($i+1), 
                        $outletModel->title,
                        '',
                        $outletModel->enrolment->title,
                        $outletModel->customer->title,
                        '',
                        strip_tags($billingStatus),
                        Yii::$app->formatter->format($outletModel->date_issued,'date'),
                        '',
                        '',
                        '',
                        '',
                        '',
                        (int)$outletModel->claim,
                        '',
                        '',
                        $outletModel->description
                    ];

                    $rowDetailCell      = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunckDataOutlet[] = $rowDetailCell;
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunckDataOutlet); 
                $writer->addRows([$rowEmpty]);

                /*
                ****************************************************************
                ****************************************************************
                RECEIVABLE  
                */
                
                $rowInfoReceivable      = WriterEntityFactory::createRowFromArray(['PENERIMAAN PEMBAYARAN ('.$formatter->asDecimal($totalReceivable).')']);
                $rowHeaderReceivable    = WriterEntityFactory::createRowFromArray(['No','Title','Kode','Nomor','Nama','Staff','Inisial','Issued','Claim','Surcharge','Penalty','Disc','Total','Payment','Balance','Due (Ovd)','Description'], $headerStyle);
                $writer->addRows([$rowInfoReceivable,$rowHeaderReceivable]);

                $plunckDataReceivable = [];
                foreach ($queryReceivable->each($dataEachLimit) as $i => $receivableModel) {
                    
                    $staffTitle =(!empty($receivableModel->staff_id)) ? 
                        $receivableModel->staff->title : '-';                       
                    
                    $staffInitial =(!empty($receivableModel->staff_id)) ? 
                        $receivableModel->staff->initial : '-';  

                    $infoTagihan = '';
                    $infoOverdue = '';
                    $queryDetails = ReceivableDetail::find()->where(['receivable_id'=>$receivableModel->id]);
                    foreach ($queryDetails->each($dataEachLimit) as $j => $queryDetailModel) {
    
                        $billing    = Billing::find()
                                        ->where(['id'=>$queryDetailModel->billing_id])
                                        ->orderBy(['billing_type'=>SORT_ASC])
                                        ->one();
    
                        $tmpBillingType =(!empty($billing->billing_type)) ?
                            $billing->getOneBillingType($billing->billing_type) : '-';
    
                        $billingType    = str_replace('Tagihan Iuran', 'Ang', $tmpBillingType);
                        $infoTagihan    = $infoTagihan.'|'.strip_tags($billingType).' '.$billing->month_period;
    
    
                        $overdueStatus =(!empty($queryDetailModel->accuracy_status)) ?
                            $queryDetailModel->getOneAccuracyStatus($queryDetailModel->accuracy_status) : '-';
    
                        $infoOverdue = $infoOverdue.'| '.strip_tags($overdueStatus).' ('.$queryDetailModel->overdue.')';
    
                    }

                    $cellValues = [
                        ($i+1), 
                        $receivableModel->invoice,
                        '',
                        $receivableModel->enrolment->title,
                        $receivableModel->customer->title,
                        $staffTitle,
                        $staffInitial,
                        Yii::$app->formatter->format($receivableModel->date_issued,'date'),
                        (int)$receivableModel->claim,
                        (int)$receivableModel->surcharge,
                        (int)$receivableModel->penalty,
                        (int)$receivableModel->discount,
                        (int)$receivableModel->total,
                        (int)$receivableModel->payment,
                        (int)$receivableModel->balance,
                        $receivableModel->getReceivableDetailOverdue(),
                        $receivableModel->description.$infoTagihan
                    ];

                    $rowDetailCell          = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunckDataReceivable[] = $rowDetailCell;
                   
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunckDataReceivable); 
                $writer->addRows([$rowEmpty]);

                /*
                ****************************************************************
                ****************************************************************
                ACCOUNT RECEIVABLE  
                */

                $rowInfoAccountReceivable      = WriterEntityFactory::createRowFromArray(['AKUN MASUK ('.$formatter->asDecimal($totalAccountReceivable).')']);
                $rowHeaderAccountReceivable    = WriterEntityFactory::createRowFromArray(['No','Title','Kode','','','Staff','Inisial','Issued','','','','','','Amount','-','-','Description'], $headerStyle);
                $writer->addRows([$rowInfoAccountReceivable,$rowHeaderAccountReceivable]);

                $plunckDataAccountReceivable = [];
                foreach ($queryAccountReceivable->each($dataEachLimit) as $i => $accountReceivableModel) {
                    
                    $staffId = (!empty($accountReceivableModel->accountReceivable->staff_id)) ? 
                        $accountReceivableModel->accountReceivable->staff_id : '-';

                    $staffTitle =(!empty($staffId)) ? $cacheCloud->getStaffTitle($staffId) : '-';                       
                    $staffInitial =(!empty($staffId)) ? $cacheCloud->getStaffInitial($staffId) : '-'; 
                                        
                    $cellValues = [
                        ($i+1), 
                        $accountReceivableModel->accountReceivable->invoice.' | '.$accountReceivableModel->invoice,
                        '',
                        '',
                        '',
                        $staffTitle,
                        $staffInitial,
                        Yii::$app->formatter->format($accountReceivableModel->accountReceivable->date_issued,'date'),
                        '',
                        '',
                        '',
                        '',
                        '',
                        (int)$accountReceivableModel->amount,
                        '',
                        '',
                        $accountReceivableModel->commentary.' | '.$accountReceivableModel->accountReceivable->description
                    ];

                    $rowDetailCell                  = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunckDataAccountReceivable[]  = $rowDetailCell;
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunckDataAccountReceivable); 
                $writer->addRows([$rowEmpty]);


                /*
                ****************************************************************
                ****************************************************************
                ACCOUNT PAYABLE  
                */

                $rowInfoAccountPayable      = WriterEntityFactory::createRowFromArray(['AKUN KELUAR ('.$formatter->asDecimal($totalAccountPayable).')']);
                $rowHeaderAccountPayable    = WriterEntityFactory::createRowFromArray(['No','Title','Kode','','','Staff','Inisial','Issued','','','','','','Amount','-','-','Description'], $headerStyle);
                $writer->addRows([$rowInfoAccountPayable,$rowHeaderAccountPayable]);


                $plunckDataAccountPayable = [];
                foreach ($queryAccountPayable->each($dataEachLimit) as $i => $accountPayableModel) {
                    
                    $staffId = (!empty($accountPayableModel->accountPayable->staff_id)) ? 
                        $accountPayableModel->accountPayable->staff_id : '-';

                    $staffTitle =(!empty($staffId)) ? $cacheCloud->getStaffTitle($staffId) : '-';                       
                    $staffInitial =(!empty($staffId)) ? $cacheCloud->getStaffInitial($staffId) : '-'; 

                    $cellValues = [
                        ($i+1), 
                        $accountPayableModel->accountPayable->invoice.' | '.$accountPayableModel->invoice,
                        $accountPayableModel->commentary,
                        '',
                        '',
                        $staffTitle,
                        $staffInitial,
                        Yii::$app->formatter->format($accountPayableModel->accountPayable->date_issued,'date'),
                        '',
                        '',
                        '',
                        '',
                        '',
                        (int)$accountPayableModel->amount,
                        '',
                        '',
                        $accountPayableModel->accountPayable->description
                    ];

                    $rowDetailCell               = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunckDataAccountPayable[]  = $rowDetailCell;
                   
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunckDataAccountPayable); 
                $writer->addRows([$rowEmpty]);
                
                ////////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////////
                //NOTES  

                $rowInfoNotes       = WriterEntityFactory::createRowFromArray(['Notes ('.$formatter->asDecimal($countNote).')']);
                $rowHeaderNote      = WriterEntityFactory::createRowFromArray(['No','Title','Jenis','','','Staff','Inisial','Issued','','','','','','','','','Description'], $headerStyle);
                $writer->addRows([$rowInfoNotes,$rowHeaderNote]);
                

                $plunckDataNote = [];
                foreach ($queryNote->each($dataEachLimit) as $i => $noteModel) {

                    $cellValues = [
                        ($i+1), 
                        $noteModel->title,
                        $noteModel->noteType->title,
                        '',
                        '',
                        $noteModel->staff->title,
                        $noteModel->staff->initial,
                        Yii::$app->formatter->format($noteModel->date_issued,'date'),
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        strip_tags($noteModel->description)
                    ];                    
                    
                    $rowDetailCell     = WriterEntityFactory::createRowFromArray($cellValues);
                    $plunckDataNote[]  = $rowDetailCell;
                }

                //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
                $writer->addRows($plunckDataNote); 
                $writer->addRows([$rowEmpty]);  
                
                
                /*
                ****************************************************************
                ****************************************************************
                SUMMARY
                */

                $rowNilaiOutlet             = WriterEntityFactory::createRowFromArray(['Nilai Outlet Baru',                          '','','','','','','','','','','',$formatter->asDecimal($totalOutlet),               '('.$countOutlet.') records']);
                $rowNilaiPenerimaan         = WriterEntityFactory::createRowFromArray(['Nilai Penerimaan',                           '','','','','','','','','','','',$formatter->asDecimal($totalReceivable),           '('.$countReceivable.') records']);
                $rowNilaiAkunPenerimaan     = WriterEntityFactory::createRowFromArray(['Nilai Akun Penerimaan',                      '','','','','','','','','','','',$formatter->asDecimal($totalAccountReceivable),    '('.$countAccountReceivable.') records']);
                $rowNilaiAkunPengeluaran    = WriterEntityFactory::createRowFromArray(['Nilai Akun Pengeluaran',                     '','','','','','','','','','','',$formatter->asDecimal($totalAccountPayable),       '('.$countAccountPayable.') records']);
                $rowNilaiTotalIncome        = WriterEntityFactory::createRowFromArray(['Total Income (Penerimaan + Akun Penerimaan)','','','','','','','','','','','',$formatter->asDecimal($totalIncome),               '('.$countIncome.') records']);
                $rowNilaiTotalOutcome       = WriterEntityFactory::createRowFromArray(['Total Outcome (Akun Pengeluaran)',           '','','','','','','','','','','',$formatter->asDecimal($totalOutcome),              '('.$countOutcome.') records']);
                $rowNilaiSummary            = WriterEntityFactory::createRowFromArray(['Summary (Income-Outcome)',                   '','','','','','','','','','','',$formatter->asDecimal($totalSummary)]);
                $rowNilaiSisaSaldo          = WriterEntityFactory::createRowFromArray(['Sisa Saldo Tgl ',                            '','','','','','','','','','','','']);
                $rowNilaiTotalSaldo         = WriterEntityFactory::createRowFromArray(['Total Saldo',                                '','','','','','','','','','','','']);
                
                $writer->addRows([
                    $rowNilaiOutlet,$rowNilaiPenerimaan,$rowNilaiAkunPenerimaan,
                    $rowNilaiAkunPengeluaran, $rowNilaiTotalIncome, $rowNilaiTotalOutcome,
                    $rowNilaiSummary, $rowNilaiSisaSaldo, $rowNilaiTotalSaldo
                ]);
                $writer->addRows([$rowEmpty]);    
                $writer->addRows([$rowEmpty]);     


                $rowTertandaTitle   = WriterEntityFactory::createRowFromArray(['Dilaporkan Oleh','','','','Diperiksa Oleh','','','','Mengetahui Oleh','','','','Disetujui Oleh',''], $titleStyle);
                $writer->addRows([$rowTertandaTitle]); 
                $writer->addRows([$rowEmpty]);    
                $writer->addRows([$rowEmpty]);  
                $writer->addRows([$rowEmpty]);    
                $writer->addRows([$rowEmpty]);    
                $rowTertandaNama    = WriterEntityFactory::createRowFromArray(['','','','','Isma Wirna','','','','Muksalmina','','','','Jamaluddin, S. Pd. I','']);              
                $rowTertandaJabatan = WriterEntityFactory::createRowFromArray(['Kasir','','','','K.A. Admin','','','','Manager Cabang','','','','Direktur','']);              
                $writer->addRows([$rowTertandaNama,$rowTertandaJabatan]); 
                
                ////////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////////
                //END ----------------------------------------------------------                

                $writer->close();                  
                
            }         
        }  
        
        $providerOutletDetail = new ArrayDataProvider([
            'allModels' => $queryOutlet->all(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        $providerAccountReceivableDetail = new ArrayDataProvider([
            'allModels' => $queryAccountReceivable->all(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $providerAccountPayableDetail = new ArrayDataProvider([
            'allModels' => $queryAccountPayable->all(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $providerReceivableDetail = new ArrayDataProvider([
            'allModels' => $queryReceivable->all(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);        
      
        return $this->render('index',[
            'profile'               => $profile,             
            
            'providerOutletDetail'              => $providerOutletDetail,
            'providerAccountReceivableDetail'   => $providerAccountReceivableDetail,
            'providerAccountPayableDetail'      => $providerAccountPayableDetail,
            'providerReceivableDetail'          => $providerReceivableDetail,
            
            'modelReportSummary'    => $modelReportSummary,
            'dateSummaryList'       => $dateSummaryList,
            'typeSummaryList'       => $typeSummaryList,
            
            'totalBillingCost'      => $formatter->asDecimal($totalOutlet),
            
            'totalIncome'           => $formatter->asDecimal($totalIncome),
            'totalOutcome'          => $formatter->asDecimal($totalOutcome),
            'totalSummary'          => $formatter->asDecimal($totalSummary),
            
            'countOutlet'           => $countOutlet,
            'countIncome'           => $countIncome,
            'countOutcome'          => $countOutcome,
            
            'dateFirst'             => Yii::$app->formatter->asDate($dateFirst,'dd/MM/yyyy'),
            'dateLast'              => Yii::$app->formatter->asDate($dateLast,'dd/MM/yyyy')
        ]);
    }
   
}