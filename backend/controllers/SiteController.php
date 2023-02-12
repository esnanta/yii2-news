<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\ChartYearly;

use backend\models\Profile;
use backend\models\Blog;

/**
 * Site controller
 */
class SiteController extends Controller
{

    private $yearList=[
        '2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022',
    ];

    private $monthList =[
                'januari','februari','maret',
                'april','mei','juni',
                'juli','agustus','september',
                'oktober','november', 'desember',
    ];


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','chart','message','flush','summary'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'flush' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionMessage()
    {
        return $this->render('message');
    }

    public function actionIndex()
    {
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

        $model      = new ChartYearly;
        $currYear   = date('Y',time());

        $model->option_year = $currYear;

        $blogs   = Blog::find()->where([
            'month_period'      => null
        ])
        ->limit(20);

        foreach ($blogs->each(5) as $blogModel) {
            $blogModel->save();
        }

        $dataset = [];
        $datasetCounter = [];
        if ($model->load(Yii::$app->request->post())) {
            for($i=1;$i<=12;$i++){
                $dataset[] = Blog::countByMonthPeriod($model->option_year, $i);
                $datasetCounter[] = Blog::getCounterByMonthPeriod($model->option_year, $i);
            }
        }
        else{

            for($i=1;$i<=12;$i++){
                $dataset[] = Blog::countByMonthPeriod($currYear, $i);
                $datasetCounter[] = Blog::getCounterByMonthPeriod($currYear, $i);
            }
        }
        return $this->render('index',[
            'model'=>$model,
            'profile'=>$profile,
            'monthList'=>$this->monthList,
            'yearList'=>$this->yearList,
            'dataset'=>$dataset,
            'datasetCounter'=>$datasetCounter

        ]);
    }

    public function actionSummary(){
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

        $model      = new ChartYearly;
        $currYear   = date('Y',time());

        $model->option_year = $currYear;



        $dataset1 = [];
        $dataset2 = [];
        $dataset3 = [];
        $datasetCounter1 = [];
        $datasetCounter2 = [];
        $datasetCounter3 = [];

        if ($model->load(Yii::$app->request->post())) {
            for($i=1;$i<=12;$i++){
                $dataset1[] = \backend\models\MailIncoming::countByMonthPeriod($model->option_year, $i);
                $dataset2[] = \backend\models\MailDisposition::countByMonthPeriod($model->option_year, $i);
                $dataset3[] = \backend\models\MailOutgoing::countByMonthPeriod($model->option_year, $i);
                $datasetCounter1[] = \backend\models\MailIncoming::getCounterByMonthPeriod($model->option_year, $i);
                $datasetCounter2[] = \backend\models\MailDisposition::getCounterByMonthPeriod($model->option_year, $i);
                $datasetCounter3[] = \backend\models\MailOutgoing::getCounterByMonthPeriod($model->option_year, $i);
            }
        }
        else{

            for($i=1;$i<=12;$i++){
                $dataset1[] = \backend\models\MailIncoming::countByMonthPeriod($currYear, $i);
                $dataset2[] = \backend\models\MailDisposition::countByMonthPeriod($currYear, $i);
                $dataset3[] = \backend\models\MailOutgoing::countByMonthPeriod($currYear, $i);
                $datasetCounter1[] = \backend\models\MailIncoming::getCounterByMonthPeriod($currYear, $i);
                $datasetCounter2[] = \backend\models\MailDisposition::getCounterByMonthPeriod($currYear, $i);
                $datasetCounter3[] = \backend\models\MailOutgoing::getCounterByMonthPeriod($currYear, $i);
            }
        }
        return $this->render('summary',[
            'model'=>$model,
            'profile'=>$profile,
            'monthList'=>$this->monthList,
            'yearList'=>$this->yearList,
            'dataset1'=>$dataset1,
            'dataset2'=>$dataset2,
            'dataset3'=>$dataset3,
            'datasetCounter1'=>$datasetCounter1,
            'datasetCounter2'=>$datasetCounter2,
            'datasetCounter3'=>$datasetCounter3,
        ]);
    }


    public function actionChart()
    {
        return $this->render('chart');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionFlush(){
        Yii::$app->cache->flush();

        Yii::$app->getSession()->setFlash('success', [
            'message' => Yii::t('app', 'Cache Flushed'),
        ]);

        $this->redirect('index');
    }
}
