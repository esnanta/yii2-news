<?php

namespace backend\controllers;

use Yii;
use backend\models\Collector;
use backend\models\CollectorSearch;
use backend\models\Area;
use backend\models\Staff;
use backend\models\Billing;

use common\helper\Helper;

use yii\helpers\ArrayHelper; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * CollectorController implements the CRUD actions for Collector model.
 */
class CollectorController extends Controller
{
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
     * Lists all Collector models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-collector')){
            $searchModel = new CollectorSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');
            $staffList  = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');                       
            
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'areaList'=>$areaList,
                'staffList'=>$staffList,                 
            ]);    
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         

    }

    /**
     * Displays a single Collector model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-collector')){
            $model      = $this->findModel($id);
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');          
            $staffList  = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');                       
            
            $datasetCredit      = [];
            $datasetInstallment = [];
            $datasetPaid        = [];            
            
            $paymentStatusCredit        = Billing::PAYMENT_STATUS_CREDIT;
            $paymentStatusInstallment   = Billing::PAYMENT_STATUS_INSTALLMENT;
            $paymentStatusPaid          = Billing::PAYMENT_STATUS_PAID;

            $currYear   = date('Y',time());

            for($i=1;$i<=12;$i++){
                $datasetCredit[]        = Billing::countPaymentStatusYearlyByArea($currYear, $i,$paymentStatusCredit,$model->area_id);
                $datasetInstallment[]   = Billing::countPaymentStatusYearlyByArea($currYear, $i,$paymentStatusInstallment,$model->area_id);
                $datasetPaid[]          = Billing::countPaymentStatusYearlyByArea($currYear, $i,$paymentStatusPaid,$model->area_id);
            }        

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'areaList'=>$areaList,
                    'staffList'=>$staffList,   
                    'datasetCredit'=>$datasetCredit,
                    'datasetInstallment'=>$datasetInstallment,
                    'datasetPaid'=>$datasetPaid,
                ]);
            }          
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }             
        
    }
        
        
    public function actionUpdateBilling($id)
    {
        if(Yii::$app->user->can('create-collector')){
            $currYear       = date('Y',time());

            $dateFirst      = strtotime($currYear.'-'.'01'.'-'.'01'.' 00:00:01');
            $dateLast       = strtotime($currYear.'-'.'12'.'-'.'31'.' 23:59:59'); 

            $dataQueryLimit             = Yii::$app->params['Data_Query_Limit'];
            $dataEachLimit              = Yii::$app->params['Data_Each_Limit'];

            $queryBillings  = Billing::find()
                ->where(['between', 'date_due',  $dateFirst,  $dateLast])
                ->andWhere(['area_id'=>null])
                ->limit($dataQueryLimit);        

            $counter = 0;
            $allData = $queryBillings->count();
            foreach ($queryBillings->each($dataEachLimit) as $billingModel) {
                $billingModel->area_id = $billingModel->customer->area_id;
                $billingModel->save();
                $counter=$counter+1;
            }

            Yii::$app->getSession()->setFlash('danger', ['message' => 'Data tersimpan '.$counter.' dari '.$allData]);
            return $this->redirect(['view', 'id' => $id]);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           

    }        
        
    /**
     * Creates a new Collector model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-collector')){
            $model = new Collector;
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');         
            $staffList  = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');                       
            

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'areaList'=>$areaList,
                    'staffList'=>$staffList,                     
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }        
            
    }

    /**
     * Updates an existing Collector model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-collector')){
            $model = $this->findModel($id);
            $areaList   = ArrayHelper::map(Area::find()->asArray()->all(), 'id','title');        
            $staffList  = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');                       

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'areaList'=>$areaList,
                    'staffList'=>$staffList,                
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         

    }

    /**
     * Deletes an existing Collector model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-collector')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Finds the Collector model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Collector the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Collector::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
