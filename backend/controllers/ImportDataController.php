<?php

namespace backend\controllers;

use Yii;
use backend\models\ImportData;
use backend\models\ImportDataSearch;
use backend\models\ImportAttribute;
use backend\models\Lookup;
use backend\models\Counter;

use backend\models\AccountType;      
use backend\models\Account;      
use backend\models\Album; 
use backend\models\Archive; 
use backend\models\Area; 
use backend\models\Author; 
use backend\models\Category; 
use backend\models\Employment; 
use backend\models\Network; 
use backend\models\Staff; 
use backend\models\Customer; 
use backend\models\Enrolment; 
use backend\models\ServiceReason; 
use backend\models\Gmap; 
use backend\models\GmapDetail; 

use backend\models\AccountPayable;
use backend\models\AccountPayableDetail; 
use backend\models\AccountReceivable;    
use backend\models\AccountReceivableDetail;    
use backend\models\Outlet;    
use backend\models\OutletDetail;    
use backend\models\Validity;      
use backend\models\ValidityDetail;      
use backend\models\Billing;    
use backend\models\Receivable;    
use backend\models\ReceivableDetail;    
use backend\models\Service;     
use backend\models\ServiceDetail;   

use common\helper\Helper as Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

/**
 * ImportDataController implements the CRUD actions for ImportData model.
 */
class ImportDataController extends Controller
{
    
    private $firstRange=[
        '1'=>'1',
        '5001'=>'5001',
        '10001'=>'10001',
        '15001'=>'15001',
        '20001'=>'20001',
        '25001'=>'25001',
        '30001'=>'30001',
        '35001'=>'35001',
        '40001'=>'40001',
        '45001'=>'45001',
    ];   
    
    private $lastRange=[
		'20'=>'20',
        '5000'=>'5000',
        '10000'=>'10000',
        '15000'=>'15000',
        '20000'=>'20000',
        '25000'=>'25000',
        '30000'=>'30000',
        '35000'=>'35000',
        '40000'=>'40000',
        '45000'=>'45000',
        '50000'=>'50000',
    ];    
    
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

    /**
     * Lists all ImportData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImportDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRead($id){
        
        ini_set('max_execution_time', 1200);//15 minutes
        ini_set('memory_limit', '1028M'); 
        
        $model              = $this->findModel($id);
        $importAttributes   = ImportAttribute::findAll(['import_data_id'=>$model->id]);
        
        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
//        $reader = ReaderFactory::create(Type::ODS); // for ODS files

//        $reader = ReaderFactory::create(Type::CSV); // for CSV files
//        $reader->setFieldDelimiter(';');
//        $reader->setFieldEnclosure('@');
//        $reader->setEndOfLineCharacter("\r");        
        
        $reader->open($model->getAssetFile());
        
        $count      = 0;
        $columnId   = 0;
        $data       = [];
        $attributes = [];
        
        $tableName = '';
        
        
        //MASTER        
        if($model->modul_type== ImportData::MODUL_TYPE_ACCOUNT_TYPE)    { $tableName= AccountType::tableName(); }     
        elseif($model->modul_type== ImportData::MODUL_TYPE_ACCOUNT)     { $tableName= Account::tableName(); }     
        elseif($model->modul_type== ImportData::MODUL_TYPE_ALBUM)       { $tableName= Album::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_ARCHIVE)     { $tableName= Archive::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_AREA)        { $tableName= Area::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_AUTHOR)      { $tableName= Author::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_CATEGORY)    { $tableName= Category::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_COUNTER)     { $tableName= Counter::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_EMPLOYMENT)  { $tableName= Employment::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_NETWORK)        { $tableName= Network::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_STAFF)       { $tableName= Staff::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_CUSTOMER)    { $tableName= Customer::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_ENROLMENT)   { $tableName= Enrolment::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_SERVICE_TYPE){ $tableName= ServiceReason::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_GMAP)        { $tableName= Gmap::tableName(); }
        elseif($model->modul_type== ImportData::MODUL_TYPE_GMAP_DETAIL) { $tableName= GmapDetail::tableName(); }
        
        //TRANSAKSI           
        elseif($model->modul_type== ImportData::MODUL_TYPE_ACCOUNT_PAYABLE)             { $tableName= AccountPayable::tableName(); }     
        elseif($model->modul_type== ImportData::MODUL_TYPE_ACCOUNT_PAYABLE_DETAIL)      { $tableName= AccountPayableDetail::tableName(); }     
        elseif($model->modul_type== ImportData::MODUL_TYPE_ACCOUNT_RECEIVABLE)          { $tableName= AccountReceivable::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_ACCOUNT_RECEIVABLE_DETAIL)   { $tableName= AccountReceivableDetail::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_OUTLET)                      { $tableName= Outlet::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_OUTLET_DETAIL)               { $tableName= OutletDetail::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_VALIDITY)                    { $tableName= Validity::tableName(); }     
        elseif($model->modul_type== ImportData::MODUL_TYPE_VALIDITY_DETAIL)             { $tableName= ValidityDetail::tableName(); }     
        elseif($model->modul_type== ImportData::MODUL_TYPE_BILLING)                     { $tableName= Billing::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_RECEIVABLE)                  { $tableName= Receivable::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_RECEIVABLE_DETAIL)           { $tableName= ReceivableDetail::tableName(); }   
        elseif($model->modul_type== ImportData::MODUL_TYPE_SERVICE)                     { $tableName= Service::tableName(); }           
        elseif($model->modul_type== ImportData::MODUL_TYPE_SERVICE_DETAIL)              { $tableName= ServiceDetail::tableName(); }   
        
        
        foreach ($importAttributes as $importAttributeModel) {
            $attributes[] = $importAttributeModel->title;
        }
        $attributes[] = 'verlock';

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $i => $row) {
                    $count = ($i-1);
                    
                    if ($count > 0 && $count >= $model->row_start && $count <= $model->row_end) {
                        $dataRow = [];
                        foreach ($importAttributes as $importAttributeModel) {
                            //ID MUST NOT BE EMPTY
                            if(!empty($row[$columnId]) || $row[$columnId] !=''){

                                $rowValue = $row[$importAttributeModel->column_index];
                                
                                $convertValue = ($importAttributeModel->conversion == ImportAttribute::DATA_CONVERSION_NA) ? 
                                    $rowValue : 
                                    self::convert($importAttributeModel->conversion,$rowValue);

                                $dataRow[] = $convertValue;
                            }
                        }
                        $dataRow[] = 0;         //ADD VERLOCK
                        $data[] = $dataRow;
                        $count++;
                    } 
                    
                    if($count > $model->row_end){
                         break;
                    }
                }
//                print_r($data);
//                die();
                
               
                //Yii::$app->db->createCommand()->update('user', ['status' => 1], 'age > 30')->execute();
                
                Yii::$app->db->createCommand()->batchInsert($tableName, $attributes, $data)->execute();
            }            

            $transaction->commit();

            $reader->close();  

            Yii::$app->getSession()->setFlash('success', [
                'message' => Yii::t('app', Html::encode('Data '.str_replace('tx_', '', $tableName).' berhasil disimpan. '.$model->row_start.'-'.$model->row_end.' ('.count($data).' records)')),
            ]);            

            return $this->redirect(['view', 'id'=>$model->id]);
            //return $this->redirect(['index']);
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private static function convert($_type,$_value){
        
        $returnValue = Lookup::getId(Yii::$app->params['LookupToken_NA']);
        
        if($_type == ImportAttribute::DATA_CONVERSION_LOOKUP){
            switch ($_value) {
                
                ////////////////////////////////////////////////////////////////
                //POSTING STATUS                   
                case ($_value==1): //DRAFT
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_Draft']);
                    break;

                case ($_value==2): //PUBLISH
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_Publish']);
                    break;
                
                ////////////////////////////////////////////////////////////////
                //PINNED STATUS                   
                case ($_value==4): //NO
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_NO']);
                    break;

                case ($_value==5): //YES
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_YES']);
                    break;                
                
                ////////////////////////////////////////////////////////////////
                //GENDER STATUS                   
                case ($_value==11): //JENIS KELAMIN LAKI2
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_Male']);
                    break;

                case ($_value==12): //JENIS KELAMIN PEREMPUAN
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_Female']);
                    break;
                          
                ////////////////////////////////////////////////////////////////
                //BILLING STATUS                 
                case ($_value==66): //PROCESS PENDING -> BILLING NO
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_NO']);
                    break;

                case ($_value==67): //PROCESS ONGOING -> BILLING YES
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_YES']);
                    break;                 
                
                case ($_value==68): //PROCESS COMPLETE -> BILLING YES
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_YES']);
                    break;                 
                
                ////////////////////////////////////////////////////////////////
                //ASSEMBLY TYPE
                case ($_value==616): //ASSEMBLY TYPE PASANG BARU
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_AssemblyTypeNew']);
                    break;

                case ($_value==617): //ASSEMBLY TYPE PASANG PINDAH
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_AssemblyTypeMoving']);
                    break;                  
                
                ////////////////////////////////////////////////////////////////
                //BILLING TYPE
                case ($_value==621): //BILLING TYPE ANGSURAN
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_BillingTypeMonthly']);
                    break;

                case ($_value==622): //BILLING TYPE INSTALASI BARU
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_BillingTypeNew']);
                    break;                  
                
                case ($_value==623): //BILLING TYPE INSTALASI PINDAH
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_BillingTypeMoving']);
                    break;                  
                
                
                ////////////////////////////////////////////////////////////////
                //PAYMENT STATUS
                case ($_value==611): //PAYMENT STATUS CREDIT (HUTANG)
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_PaymentStatusCredit']);
                    break;

                case ($_value==612): //PAYMENT STATUS INSTALLMENT (CICILAN)
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_PaymentStatusInstallment']);
                    break;                  
                
                case ($_value==613): //PAYMENT STATUS PAID OFF (LUNAS)
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_PaymentStatusPaidOff']);
                    break;                     
                
                ////////////////////////////////////////////////////////////////
                //OUTLET STATUS
                case ($_value==641): //OUTLET STATUS AKTIF
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusActive']);
                    break;

                case ($_value==642): //OUTLET STATUS DC TEMPORER
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusIdle']);
                    break;   

                case ($_value==643): //OUTLET STATUS DC PERMANEN
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusDisconnect']);
                    break;

                case ($_value==644): //OUTLET STATUS GRATIS
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusFree']);
                    break;   
                
                ////////////////////////////////////////////////////////////////
                //OUTLET TYPE                
                case ($_value==646): //OUTLET TYPE INDUK
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceMain']);
                    break;

                case ($_value==647): //OUTLET TYPE PARALEL
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceParalel']);
                    break;                  
                
                ////////////////////////////////////////////////////////////////
                //OVERDUE STATUS              
                case ($_value==651): //TELAT
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_Overdue']);
                    break;

                case ($_value==652): //CERMAT
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_OnTime']);
                    break;             
                
                case ($_value==653): //NA
                    $returnValue = Lookup::getId(Yii::$app->params['LookupToken_NA']);
                    break;   
                
                default:
                    return $returnValue;
            }
        }
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_BLOG_CONTENT){ 
            return str_replace('_x000D_', '', $_value);
        }       
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_CREATE_UPDATE){ 
                switch ($_value) { 
                    case ($_value==3): //isma
                        $returnValue = 2;
                        break;       
                    case ($_value==9): //anggi
                        $returnValue = 3;
                        break;    
                    case ($_value==10): //nanda sofyan
                        $returnValue = 4;
                        break;            
                    case ($_value==11): //santiramadhani
                        $returnValue = 5;
                        break;           
                    case ($_value==12): //muksalmina
                        $returnValue = 6;
                        break;  
                    case ($_value==13): //taufikhidayat
                        $returnValue = 7;
                        break;            
                    case ($_value==14): //cutrizkiyoanna
                        $returnValue = 8;
                        break;      
                    
                    default:
                        $returnValue = 1;                    
                }
        }
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_INVOICE){ 

                switch ($_value) {    
                    case ($_value==NULL): 
                        $returnValue = Counter::getSerialNumber(Yii::$app->params['LookupToken_NA']);
                        break;     
                    case ($_value=='NULL'): 
                        $returnValue = Counter::getSerialNumber(Yii::$app->params['LookupToken_NA']);
                        break;   					
                    case ($_value==''): 
                        $returnValue = Counter::getSerialNumber(Yii::$app->params['LookupToken_NA']);
                        break;                       
                    case ($_value=='-'): 
                        $returnValue = Counter::getSerialNumber(Yii::$app->params['LookupToken_NA']);
                        break;                      
                    case (strpos($_value, 'IN-15-') !== false): 
                        $returnValue = str_replace('IN-15-', 'I15', $_value);
                        break;    
                    case (strpos($_value, 'BI-15-') !== false): 
                        $returnValue = str_replace('BI-15-', 'B15', $_value);
                        break;     
                    case (strpos($_value, 'RV-15-') !== false): 
                        $returnValue = str_replace('RV-15-', 'R15', $_value);
                        break;                      
                    case (strpos($_value, '2015-') !== false): 
                        $returnValue = str_replace('2015-', '15', $_value);
                        break; 
                    case (strpos($_value, '2016-') !== false): 
                        $returnValue = str_replace('2016-', '16', $_value);
                        break; 
                    case (strpos($_value, '16-') !== false): 
                        $returnValue = str_replace('16-', '16X', $_value);
                        break;   
                    case (strpos($_value, '15-') !== false): 
                        $returnValue = str_replace('15-', '15X', $_value);
                        break;    
                    case (strpos($_value, '14-') !== false): 
                        $returnValue = str_replace('14-', '14X', $_value);
                        break;  

                    case (strpos($_value, '17-17') !== false): 
                        $returnValue = str_replace('17-17', '17', $_value);
                        break; 
                    
                    case (strpos($_value, '18-17') !== false): 
                        $returnValue = str_replace('18-17', '17', $_value);
                        break;                      
                    
                    case (strpos($_value, '18-18') !== false): 
                        $returnValue = str_replace('18-18', '18', $_value);
                        break;                     
                    
                    case (strpos($_value, '18-A-') !== false): 
                        $returnValue = str_replace('18-A-', '18-A', $_value);
                        break;  

                    case (strpos($_value, '18-18-A-') !== false): 
                        $returnValue = str_replace('18-18-A-', '18-A', $_value);
                        break;                      
                    
                    case (strpos($_value, '18- A-') !== false): 
                        $returnValue = str_replace('18- A-', '18-A', $_value);
                        break; 

                    case (strpos($_value, '18-B-') !== false): 
                        $returnValue = str_replace('18-B-', '18-B', $_value);
                        break;                      
                    
                    case (strpos($_value, '18-X-') !== false): 
                        $returnValue = str_replace('18-X-', '18-X', $_value);
                        break;                       
                    
                    case (strpos($_value, '18-Y-') !== false): 
                        $returnValue = str_replace('18-Y-', '18-Y', $_value);
                        break;                          
                    
                    case (strpos($_value, '18-C-') !== false): 
                        $returnValue = str_replace('18-C-', '18-C', $_value);
                        break;                     
                    
                    case (strpos($_value, '18-c-') !== false): 
                        $returnValue = str_replace('18-c-', '18-C', $_value);
                        break;                    
                    
                    case (strpos($_value, '18-18C') !== false): 
                        $returnValue = str_replace('18-18C', '18-C', $_value);
                        break;      
                    
                    case (strpos($_value, '18- ') !== false): 
                        $returnValue = str_replace('18- ', '18', $_value);
                        break;                       
                    
                    case (strpos($_value, '2012-') !== false): 
                        $returnValue = str_replace('2012-', '12', $_value);
                        break;   
                    case (strpos($_value, '2013-') !== false): 
                        $returnValue = str_replace('2013-', '13', $_value);
                        break;      
                    case (strpos($_value, '2014-') !== false): 
                        $returnValue = str_replace('2014-', '14', $_value);
                        break;    
                    case (strpos($_value, '1900-') !== false): 
                        $returnValue = str_replace('1900-', 'xx', $_value);
                        break;     
                    case (strpos($_value, '1899-') !== false): 
                        $returnValue = str_replace('1899-', 'yy', $_value);
                        break;                       
                    
                    default:
                        $returnValue = $_value;      
                }             

        }
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_VALIDITY){ 
            $validity = Validity::find()->where(['title'=>$_value])->one();
            return $validity->id;
        }
        elseif($_type == ImportAttribute::DATA_CONVERSION_MONTH_PERIOD){
            $returnValue = Helper::getMonthPeriod($_value);
        }        
        elseif($_type == ImportAttribute::DATA_CONVERSION_PHONE_NUMBER){
            $returnValue = (substr($_value,0,1)==8) ? '0'.$_value : $_value ;
        }         
        elseif($_type == ImportAttribute::DATA_CONVERSION_FORMAT_NUMBER){
            $returnValue = Counter::convert($_value);
        }
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_DATETIME_TO_STRING){
            $returnValue = Yii::$app->formatter->format($_value, 'date');
        }  
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_BILLING_CYCLE){
            $cycleValue = (date('d',$_value) > 28) ? '1': date('d',$_value);
            $returnValue = $cycleValue;
        }        
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_SERVICE_TYPE){ 

                switch ($_value) {         
                    case ($_value=='691'): // DC PERMANENT
                        $returnValue = 1; // SERVICE TYPE DC PERMANENT
                        break;                       
                    case ($_value=='692'): // DC SEMENTARA
                        $returnValue = 2; // SERVICE TYPE DC SEMENTARA;
                        break;                      
                    case ($_value=='693'): // SAMBUNG KEMBALI
                        $returnValue = 2; // SERVICE TYPE SAMBUNG KEMBALI;
                        break;  
                    case ($_value=='694'): // GRATIS
                        $returnValue = 2; // GRATIS;
                        break;                                      
                }             

        }        
        
        elseif($_type == ImportAttribute::DATA_CONVERSION_SERVICE_TO_DEVICE){ 

                switch ($_value) {         
                    case ($_value=='691'): // DC PERMANENT
                        $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusDisconnect']); // SERVICE TYPE DC PERMANENT
                        break;                       
                    case ($_value=='692'): // DC SEMENTARA
                        $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusIdle']); // SERVICE TYPE DC SEMENTARA;
                        break;                      
                    case ($_value=='693'): // SAMBUNG KEMBALI
                        $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusActive']); // SERVICE TYPE SAMBUNG KEMBALI;
                        break;  
                    case ($_value=='694'): // GRATIS
                        $returnValue = Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusFree']); // GRATIS;
                        break;                      
                    
                    default:
                        $returnValue = Counter::getSerialNumber(Yii::$app->params['LookupToken_NA']);                  
                }             

        }         

        return $returnValue;
    }
    
    
    /**
     * Displays a single ImportData model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerImportAttribute = new \yii\data\ArrayDataProvider([
            'allModels' => $model->importAttributes,
            'sort' => [
                'attributes' => ['column_index'],
            ],            
        ]);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['read','id'=>$id]);
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerImportAttribute' => $providerImportAttribute,
            'firstRange'=>$this->firstRange,
            'lastRange'=>$this->lastRange,            
        ]);
    }

    /**
     * Creates a new ImportData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        ini_set('post_max_size', '20M');
        ini_set('upload_max_filesize', '20M');         
        
        $model = new ImportData();
        $dataList = ImportData::getArrayModule();
        
        try {
            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
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
                'dataList'=>$dataList,
            ]);              
        } 
        catch (StaleObjectException $e) {
            throw new StaleObjectException('The object being updated is outdated.');
        }        

    }

    public function actionDuplicate($id){
        $model = $this->findModel($id);
        $importAttributes = ImportAttribute::find()->where(['import_id'=>$id])->all();
        
        $newImport = new ImportData;
        $newImport->modul_type = $model->modul_type;
        $newImport->title = $modul->title;
        $newImport->row_start = $modul->row_start;
        $newImport->row_end = $modul->row_end;
        $newImport->description = $modul->description;
        $newImport->save();
        
        foreach ($importAttributes as $attributeModel) {
            $newAttribute = new ImportAttribute;
            $newAttribute->import_data = $newImport->id;
            $newAttribute->title = $attributeModel->title;
            $newAttribute->column_index = $attributeModel->column_index;
            $newAttribute->conversion = $attributeModel->conversion;
            $newAttribute->description = $attributeModel->description;
            $newAttribute->save();
        }
        
        Yii::$app->getSession()->setFlash('success', [
            'message' => Yii::t('app', Html::encode('Data duplicate berhasil dibuat.')),
        ]);          
        
        return $this->redirect(['view', 'id'=>$newImport->id]);
    }
    
    /**
     * Updates an existing ImportData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        ini_set('post_max_size', '20M');
        ini_set('upload_max_filesize', '20M');        
        
        $model = $this->findModel($id);
        $dataList = ImportData::getArrayModule();
        
        $oldFile = $model->getAssetFile();
        $oldAvatar = $model->file_name;
        $oldFileName = $model->title;
        
        
        try {
            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
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
                'dataList'=>$dataList
            ]);
        } 
        catch (StaleObjectException $e) {
            throw new StaleObjectException('The object being updated is outdated.');
        }
        
    }

    /**
     * Deletes an existing ImportData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the ImportData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImportData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImportData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ImportAttribute
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddImportAttribute()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ImportAttribute');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formImportAttribute', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
