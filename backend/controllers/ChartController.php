<?php

namespace backend\controllers;

use common\models\Applicant;
use common\models\Article;
use common\models\app\ChartYearly;
use Yii;
use yii\web\Controller;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ChartController extends Controller
{
    
    private $yearList=[
        '2020'=>'2020',
    ];    
    
    private $monthList =[
                'januari','februari','maret', 
                'april','mei','juni', 
                'juli','agustus','september', 
                'oktober','november', 'desember',          
    ];
    
    private $yearMonthList=[
        '2019-03'=>'Mar 2019',
        '2020-02'=>'Feb 2020',
        '2020-03'=>'Mar 2020',
    ];    
    
    private $dayList =[
                '01','02','03',
                '04','05','06',
                '07','08','09',
                '10','11','12',
    ];    
    
    public function actionApplicantDaily()
    {
        ini_set('max_execution_time', 1200);//15 minutes

        $model          = new ChartYearly;
        $currYearMonth  = date('Y',time()).'-'.date('m',time());
        
        
        $model->option_year = $currYearMonth;
       
        $dataset = [];
        
        if ($model->load(Yii::$app->request->post())) {
            foreach($this->dayList as $i => $day){
                $dataset[] = Applicant::countDaily($model->option_year, $day);
            }                      
        }
        else{
            foreach($this->dayList as $i => $day){
                $dataset[] = Applicant::countDaily($currYearMonth, $day);
            }                           
        }
        
        return $this->render(
            'applicant_daily',[
                'model'=>$model,
                'dayList'=>$this->dayList,
                'yearMonthList'=>$this->yearMonthList,
                'dataset'=>$dataset
            ]
        );        

    }
    
    public function actionBlogYearly()
    {
        ini_set('max_execution_time', 1200);//15 minutes

        $model      = new ChartYearly;
        $currYear   = date('Y',time());
        
        $model->option_year = $currYear;
        
        $blogs   = Article::find()->where([
            'month_period'      => null
        ])
        ->limit(20);        
        
        foreach ($blogs->each(5) as $blogModel) {
            $blogModel->save();
        }
        
        $dataset = [];
        
        if ($model->load(Yii::$app->request->post())) {
            for($i=1;$i<=12;$i++){
                $dataset[] = Article::countByMonthPeriod($model->option_year, $i);
            }            
        }
        else{
            
            for($i=1;$i<=12;$i++){
                $dataset[] = Article::countByMonthPeriod($currYear, $i);
            }              
        }
        
        return $this->render(
            'new_customer_yearly',[
                'model'=>$model,
                'monthList'=>$this->monthList,
                'yearList'=>$this->yearList,
                'dataset'=>$dataset
            ]
        );        

    } 
      
}

