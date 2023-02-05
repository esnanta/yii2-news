<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\User;
use common\models\ChartUser;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ChartUserController extends Controller
{

    private $yearList=[
        '2011'=>'2011','2012'=>'2012','2013'=>'2013','2014'=>'2014','2015'=>'2015',
        '2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020',
    ];

    private $monthList =[
                'Januari','Februari','Maret',
                'April','Mei','Juni',
                'Juli','Agustus','September',
                'Oktober','November', 'Desember',
    ];

    public function actionYearly($data)
    {
        ini_set('max_execution_time', 1200);//15 minutes
        
        $model                  = new ChartUser;
        $userList               = ArrayHelper::map(User::find()->asArray()->all(), 'id','username');           
        
        $currYear               = date('Y',time());
        $currUser               = Yii::$app->user->id;
        $model->data            = $data;
        $model->option_year     = $currYear;
        $model->option_user_id  = $currUser;
        
        $chartTitle          = 'Grafik Input Data ';
        
        switch ($model->data) {
            case 1:
                $chartTitle  = $chartTitle.'Account Payable';
                break;
            case 2:
                $chartTitle  = $chartTitle.'Account Receivable';
                break;
            case 3:
                $chartTitle  = $chartTitle.'Outlet';
                break;
            case 4:
                $chartTitle  = $chartTitle.'Receivable';
                break; 
            case 5:
                $chartTitle  = $chartTitle.'Service';
                break;            
        }        

        $dataset = [];

        if ($model->load(Yii::$app->request->post())) {
            for($i=1;$i<=12;$i++){
                $dataset[] = User::countData($model->option_user_id,$model->option_year, $i, $model->data);
            }
        }
        else{
            for($i=1;$i<=12;$i++){
                $dataset[] = User::countData($currUser,$currYear, $i, $model->data);
            }
        }

        return $this->render(
            'yearly',[
                'model'=>$model,
                'monthList'=>$this->monthList,
                'yearList'=>$this->yearList,
                'userList'=>$userList,
                'dataset'=>$dataset,
                'chartTitle'=>$chartTitle
            ]
        );
    }
    
}

