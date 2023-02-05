<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\Staff;
use backend\models\AccountPayable;

use common\models\ReportAccount_PR;
use common\helper\ReportCloud;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReportAccountPayableController extends Controller
{

    public function actionAccountPayable()
    {

        $model              = new ReportAccount_PR();
        $staffList          = ArrayHelper::map(Staff::find()->asArray()->all(), 'id','title');
        $dateAttributeList  = ['date_issued'=>'Date Issued'];

        if ($model->load(Yii::$app->request->post())) {

            $formatter      = \Yii::$app->formatter;
            $title          = 'ACCOUNT PAYABLE';
            $filename       = $title.' '.Yii::$app->formatter->asDate(time(),'dd-MM-yy');
            $dateFirst      = $model->date_first;
            $dateLast       = $model->date_last;
            $query          = AccountPayable::find()
                                ->where(['between', $model->option_date,  $dateFirst,  $dateLast])
                                ->orderBy(['date_issued'=>SORT_ASC]);

            if(!empty($model->staff_id)){
                $query->andWhere(['staff_id'=>$model->staff_id]);
            }

            $totalPayment    = ($query->sum('payment')== null) ? '0' : $query->sum('payment');
            $countRecords    = ($query->count()== null) ? '0' : $query->count() ;

            $headerStyle    = ReportCloud::getHeaderStyle();
            $rowStyle       = ReportCloud::getRowStyle();


            $writer = ReportCloud::getWriterFactory();
            $writer->openToBrowser($filename.ReportCloud::getFileExtension());
            $writer->getCurrentSheet();
            $writer->setDefaultRowStyle($rowStyle);

            $rangeDate          = Yii::$app->formatter->asDate($dateFirst,'dd/MM/yy').' - '.Yii::$app->formatter->asDate($dateLast,'dd/MM/yy');
            
            $rowEmpty           = WriterEntityFactory::createRowFromArray(['']);
            $rowTitle           = WriterEntityFactory::createRowFromArray([$title           ,'','('.$rangeDate.')']);
            $rowTanggalPrint    = WriterEntityFactory::createRowFromArray(['Tanggal Print ' ,'',Yii::$app->formatter->asDate(time(),'dd/MM/yy HH:mm:ss')]);
            $rowTotalRecords    = WriterEntityFactory::createRowFromArray(['Total Records'  ,'',$formatter->asDecimal($countRecords)]);
            $rowTotalPayment    = WriterEntityFactory::createRowFromArray(['Total Payment'  ,'',$formatter->asDecimal($totalPayment)]);
            $writer->addRows([$rowTitle,$rowTanggalPrint,$rowTotalRecords,$rowTotalPayment,$rowEmpty]);

            $rowTableHeader    = WriterEntityFactory::createRowFromArray(['No','Staff','Periode','Issued','Deskripsi','Total','Payment'], $headerStyle);
            $writer->addRows([$rowTableHeader]);

            $plunck_data    = [];
            $dataEachLimit  = Yii::$app->params['Data_Each_Limit'];
            
            foreach ($query->each($dataEachLimit) as $i => $recordModel) {

                $staffTitle =(!empty($recordModel->staff_id)) ? $recordModel->staff->title : '-';

                $cellValues = [
                    ($i+1), 
                    $staffTitle,
                    $recordModel->month_period,
                    Yii::$app->formatter->format($recordModel->date_issued, 'date'),
                    $recordModel->description,
                    (int)$recordModel->total,
                    (int)$recordModel->payment
                ];

                $rowDetailCell  = WriterEntityFactory::createRowFromArray($cellValues);
                $plunck_data[]  = $rowDetailCell;
            }

            //PLUNCK ROW SUDAH DALAM BENTUK ARRAY, SO REMOVE []
            $writer->addRows($plunck_data); 
            $writer->close();

        }
        else {
            return $this->render('_form_account_pr', [
                'model' => $model,
                'dateAttributeList'=>$dateAttributeList,
                'staffList'=>$staffList,
            ]);
        }
    }


}

