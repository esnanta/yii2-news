<?php
namespace backend\controllers;

use common\helper\MessageHelper;
use common\models\app\ChartYearly;
use common\models\app\LoginForm;
use common\models\Article;
use common\models\Employment;
use common\models\Office;
use common\models\Profile;
use common\models\Staff;
use common\models\UserDektrium;
use common\service\CacheService;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

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
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','chart','message','flush','summary',
                                        'create-owner','create-regular'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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

        $officeId       = CacheService::getInstance()->getOfficeId();
        $staffId        = CacheService::getInstance()->getStaffId();

        $profile        = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $office         = Office::find()->where(['id' => $officeId])->one();
        $staff          = Staff::find()->where(['id' => $staffId])->one();


        $model      = new ChartYearly;
        $currYear   = date('Y',time());

        $model->option_year = $currYear;

        $blogs   = Article::find()->where([
            //'month_period'      => null
        ])
        ->limit(20);

        foreach ($blogs->each(5) as $blogModel) {
            $blogModel->save();
        }

        $dataset = [];
        $datasetCounter = [];
        if ($model->load(Yii::$app->request->post())) {
            for($i=1;$i<=12;$i++){
                $dataset[] = 0;//Article::countByMonthPeriod($model->option_year, $i);
                $datasetCounter[] = 0;//Article::getCounterByMonthPeriod($model->option_year, $i);
            }
        }
        else{

            for($i=1;$i<=12;$i++){
                $dataset[] = 0;//Article::countByMonthPeriod($currYear, $i);
                $datasetCounter[] = 0;//Article::getCounterByMonthPeriod($currYear, $i);
            }
        }
        return $this->render('index',[
            'model'=>$model,
            'profile'=>$profile,
            'staff' => $staff,
            'monthList'=>$this->monthList,
            'yearList'=>$this->yearList,
            'dataset'=>$dataset,
            'datasetCounter'=>$datasetCounter

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

    //NOT AVAILABLE
    public function actionCreateOwner(): Response|string
    {
        if (Yii::$app->user->can('create-user-owner')) {
            $model          = new UserDektrium();
            $userTypeList[] = [Yii::$app->params['userRoleOwner'] => 'Owner'];

            $transaction    = Yii::$app->db->beginTransaction();
            try {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->db->createCommand()->insert('tx_auth_assignment', [
                        'item_name'         => $model->user_type,
                        'user_id'           => $model->id,
                        'created_at'        => time(),
                    ])->execute();

                    $office = new Office;
                    $office->user_id        = $model->id;
                    $office->title          = $model->office_title;
                    $office->email          = $model->email;
                    $office->save();

                    $employment = new Employment;
                    $employment->office_id  = $office->id; //OFFICE
                    $employment->title      = 'Manager';
                    $employment->sequence   = '1';
                    $employment->save();

                    $staff = new Staff;
                    $staff->office_id       = $office->id; //OFFICE
                    $staff->user_id         = $model->id; //USER
                    $staff->employment_id   = $employment->id; //EMPLOYMENT
                    $staff->title           = $model->staff_title;
                    $staff->save();

                    $transaction->commit();

                    return $this->redirect(['/user/admin/index']);
                } else {
                    return $this->render('create_user_owner', [
                        'model' => $model,
                        'userTypeList'=>$userTypeList
                    ]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }


    /**
     * @throws Exception
     * @throws \Throwable
     * @throws ForbiddenHttpException
     */
    public function actionCreateRegular(): Response|string
    {
        if (Yii::$app->user->can('create-user-regular')) {
            $officeId   = CacheService::getInstance()->getOfficeId();
            $authItemName   = CacheService::getInstance()->getAuthItemName();

            $canCreateRegular = false;
            if ($authItemName == Yii::$app->params['userRoleAdmin'] ||
                $authItemName == Yii::$app->params['userRoleOwner']) {
                $canCreateRegular = true;
            }

            if ($canCreateRegular) {
                $model          = new UserDektrium;
                $userTypeList[] = [Yii::$app->params['userRoleRegular'] => 'Staff'];

                $employmentList = ArrayHelper::map(Employment::find()
                    ->where(['office_id' => $officeId])
                    ->asArray()->all(), 'id', 'title');

                $transaction    = Yii::$app->db->beginTransaction();
                try {
                    if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        Yii::$app->db->createCommand()->insert('tx_auth_assignment', [
                            'item_name'         => $model->user_type,
                            'user_id'           => $model->id,
                            'created_at'        => time(),
                        ])->execute();

                        $staff = new Staff;
                        $staff->office_id       = $officeId; //OFFICE
                        $staff->user_id         = $model->id; //USER
                        $staff->employment_id   = $model->employment_id; //EMPLOYMENT
                        $staff->title           = $model->staff_title;
                        $staff->save();

                        $transaction->commit();

                        return $this->redirect(['/staff/index']);
                    } else {
                        return $this->render('create_user_regular', [
                            'model' => $model,
                            'employmentList' => $employmentList,
                            'userTypeList' => $userTypeList,
                        ]);
                    }
                } catch (\Exception|\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                MessageHelper::getFlashAccessDenied();
                throw new ForbiddenHttpException;
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }


    }
}
