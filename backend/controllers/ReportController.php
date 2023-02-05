<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper; 

use backend\models\Applicant;
use backend\models\ApplicantAlmamater;
use backend\models\ApplicantFamily;

use common\models\ReportApplicant;
use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;



/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportController extends Controller
{

    public function actionApplicant()
    {

        $model              = new ReportApplicant;
        $dataListAsc        = ArrayHelper::map(Applicant::find()->orderBy(['record_number'=>SORT_ASC])->asArray()->all(), 'record_number','record_number');
        //$dataListDesc       = ArrayHelper::map(Applicant::find()->orderBy(['record_number'=>SORT_DESC])->asArray()->all(), 'record_number','record_number');
       
        $finalStatusList    = Applicant::getArrayFinalStatus();        
        $approvalStatusList = Applicant::getArrayApprovalStatus(); 
        $genderStatusList   = Applicant::getArrayGenderStatus(); 
        
        $dataEachLimit      = Yii::$app->params['Data_Each_Limit'];
        
        $lookupTypeFather   = ApplicantFamily::FAMILY_TYPE_FATHER; 
        $lookupTypeMother   = ApplicantFamily::FAMILY_TYPE_MOTHER; 
        $lookupTypeGuardian = ApplicantFamily::FAMILY_TYPE_GUARDIAN;                             

        if ($model->load(Yii::$app->request->post())) {
            
            $formatter      = \Yii::$app->formatter;
            $filename       = 'APPLICANT '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');            
            $query          = Applicant::find()->where(['between', 'record_number', $model->data_first, $model->data_last])
                                ->andWhere(['<>','title','']);
                    
            if(!empty($model->final_status)){
                $query->andWhere(['final_status'=>$model->final_status]);
            }            
            
            if(!empty($model->approval_status)){
                $query->andWhere(['approval_status'=>$model->approval_status]);
            }               
            
            if(!empty($model->gender_status)){
                $query->andWhere(['gender_status'=>$model->gender_status]);
            }                
            
            $countRecords   = $query->count(); 
            
            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();        
            
            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);
            
            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray(['PSB 2020-2021']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print '.Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $writer->addRows([$rowTitle,$rowTanggalPrint,$rowEmpty]);            
            
            $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records','',$formatter->asDecimal($countRecords)]);
            $writer->addRows([$rowTotalRecords,$rowEmpty]);
            
            $rowTableHeader     = WriterEntityFactory::createRowFromArray([
                /*00*/'No',
                /*01-08*/'No Peserta', 'Issued', 'Nama', 'Panggilan','NIK', 'JK','Alamat', 'Telpon', 'Email', 
                /*09-13*/'Asal Sekolah','NPSN', 'NISN', 'NIS', 'Tingkat', 'Status','Lama Belajar','Telpon Sekolah',
                /*14-18*/'Nama Ayah', 'Telpon Ayah', 'Pendidikan', 'Pekerjaan', 'Pendapatan', 
                /*19-23*/'Nama Ibu', 'Telpon Ibu', 'Pendidikan', 'Pekerjaan', 'Pendapatan',
                /*24-28*/'Nama Wali', 'Telpon Wali', 'Pendidikan', 'Pekerjaan', 'Pendapatan',
                /*29-31*/'Rata-rata', 'Finalisasi', 'Tgl Finalisasi', 'Approval','Tgl Approval'
            ], $headerStyle);            
            
            $writer->addRows([$rowTableHeader]);
            
            $plunck_data = [];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {
                
                $address    = $recordModel->address_street.', '.$recordModel->address_village.', '
                                .$recordModel->address_sub_district.', '.$recordModel->address_city.', '.$recordModel->address_province;
                
                $applicantAlmamater = ApplicantAlmamater::find()->where(['applicant_id'=>$recordModel->id])->one();                                            
                $applicantFather    = ApplicantFamily::find()->where(['applicant_id'=>$recordModel->id,'family_type'=>$lookupTypeFather])->one();                
                $applicantMother    = ApplicantFamily::find()->where(['applicant_id'=>$recordModel->id,'family_type'=>$lookupTypeMother])->one();
                $applicantGuardian  = ApplicantFamily::find()->where(['applicant_id'=>$recordModel->id,'family_type'=>$lookupTypeGuardian])->one();
                
                $cellValues = [
                    ($i+1), 
                    $recordModel->record_number,
                    Yii::$app->formatter->format($recordModel->created_at, 'date'),
                    $recordModel->title,
                    $recordModel->nick_name,
                    $recordModel->identity_number,
                    strip_tags($recordModel->getOneGenderStatus($recordModel->gender_status)),
                    $address,
                    $recordModel->phone_number,
                    $recordModel->user->email,
                    ////////////////////////////////////////////////////////////////
                    (!empty($applicantAlmamater->title)) ? $applicantAlmamater->title : '-' ,
                    (!empty($applicantAlmamater->national_school_principal_number)) ? $applicantAlmamater->national_school_principal_number : '-',
                    (!empty($applicantAlmamater->national_registration_number)) ? $applicantAlmamater->national_registration_number : '-',
                    (!empty($applicantAlmamater->school_registration_number)) ? $applicantAlmamater->school_registration_number : '-',
                    (!empty($applicantAlmamater->educational_stage_id)) ? $applicantAlmamater->educationalStage->title : '-' ,
                    strip_tags($applicantAlmamater->getOneSchoolStatus($applicantAlmamater->school_status)),
                    $applicantAlmamater->study_time_length,
                    $applicantAlmamater->phone_number,
                    ////////////////////////////////////////////////////////////////
                    (!empty($applicantFather->title)) ? $applicantFather->title : '-',
                    (!empty($applicantFather->phone_number)) ? $applicantFather->phone_number : '-',
                    (!empty($applicantFather->educational_stage_id)) ? $applicantFather->educationalStage->title :'-',
                    (!empty($applicantFather->occupation_id)) ? $applicantFather->occupation->title : '-',
                    (!empty($applicantFather->income_id)) ? $applicantFather->income->title : '-',
                    ////////////////////////////////////////////////////////////////
                    (!empty($applicantMother->title)) ? $applicantMother->title : '-',
                    (!empty($applicantMother->phone_number)) ? $applicantMother->phone_number : '-',
                    (!empty($applicantMother->educational_stage_id)) ? $applicantMother->educationalStage->title : '-',
                    (!empty($applicantMother->occupation_id)) ? $applicantMother->occupation->title : '-',
                    (!empty($applicantMother->income_id)) ? $applicantMother->income->title : '-',
                    ////////////////////////////////////////////////////////////////
                    (!empty($applicantGuardian->title)) ? $applicantGuardian->title : '-',
                    (!empty($applicantGuardian->phone_number)) ? $applicantGuardian->phone_number : '-',
                    (!empty($applicantGuardian->educational_stage_id)) ? $applicantGuardian->educationalStage->title : '-',
                    (!empty($applicantGuardian->occupation_id)) ? $applicantGuardian->occupation->title : '-',
                    (!empty($applicantGuardian->income_id)) ? $applicantGuardian->income->title : '-',    
                    ////////////////////////////////////////////////////////////////
                    $recordModel->sumAverage(),
                    strip_tags($recordModel->getOneFinalStatus($recordModel->final_status)),
                    (!empty($recordModel->date_final)) ? Yii::$app->formatter->format($recordModel->date_final, 'date') : '-',
                    strip_tags($recordModel->getOneApprovalStatus($recordModel->approval_status)),
                    (!empty($recordModel->date_approval)) ? Yii::$app->formatter->format($recordModel->date_approval, 'date') : '-',                    
                    
                ];                
                
                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;
               
            }

            
            $writer->addRows($plunck_data); 
            $writer->addRows([$rowEmpty]);
            $writer->close();        
            
        } 
        else {
            return $this->render('_form_applicant', [
                'model'                 => $model,
                'dataListAsc'           => $dataListAsc,
                'dataListDesc'          => $dataListAsc,
                'finalStatusList'       => $finalStatusList,
                'approvalStatusList'    => $approvalStatusList,
                'genderStatusList'      => $genderStatusList,
            ]);
        }        
        
    }    

   
}

