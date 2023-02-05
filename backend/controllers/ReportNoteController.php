<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\Note;
use backend\models\NoteType;

use common\models\ReportNote;
use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportNoteController extends Controller
{

    public function actionNote()
    {

        $model              = new ReportNote;
        $dataList           = ArrayHelper::map(NoteType::find()->asArray()->all(), 'id','title');
        $dataEachLimit      = Yii::$app->params['Data_Each_Limit'];

        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;

            $title          = 'Note';
            $filename       = $title;
            $dateFirst      = $model->date_first;
            $dateLast       = $model->date_last;            
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];

            $filename       = 'Note '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');
            $query          = Note::find()->where(['between', 'date_issued', $model->date_first, $model->date_last]);
                                $query->andWhere(['note_type_id'=>$model->option_type]);
         
            $countRecords   = ($query->count()== null) ? '0' : $query->count();

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();

            $writer         = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);  
            
            $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');
            
            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'','('.$rangeDate.')']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print'  ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
    

            $writer->addRows([
                $rowTitle,$rowTanggalPrint,$rowTotalRecords,
                $rowEmpty
            ]);

            $rowTableHeader    = WriterEntityFactory::createRowFromArray([
                'No','Type','Title','Staff','Issued','Description',''
            ], $headerStyle);
            $writer->addRows([$rowTableHeader]);
        
            $plunck_data = [];
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $cellValues = [
                    ($i+1), 
                    $recordModel->noteType->title,
                    $recordModel->title,
                    (empty($recordModel->staff_id)) ? '-' : $recordModel->staff->title,
                    Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                    strip_tags($recordModel->description),
                    ''
                ];
    
                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data); 
            $writer->close();

        }
        else {
            return $this->render('_form_note', [
                'model' => $model,
                'dataList'=>$dataList,
            ]);
        }

    }    

}

