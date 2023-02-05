<?php

namespace backend\controllers;

use Yii;
use backend\models\AccountReceivable;
use backend\models\AccountReceivableSearch;
use backend\models\Staff;

use common\helper\CacheCloud;
use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 

use kartik\widgets\ActiveForm;
use yii\web\Response;

/**
 * AccountReceivableController implements the CRUD actions for AccountReceivable model.
 */
class AccountReceivableController extends Controller
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
     * Lists all AccountReceivable models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-account-receivable')){
            $searchModel = new AccountReceivableSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Displays a single AccountReceivable model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-account-receivable')){
            $model      = $this->findModel($id);       
            $dataList   = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');
                        
            
            $providerAccountReceivableDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->accountReceivableDetails,
            ]);
            return $this->render('view', [
                'model' => $this->findModel($id),
                'dataList' => $dataList,
                'providerAccountReceivableDetail' => $providerAccountReceivableDetail,
            ]);          
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
    }

    /**
     * Creates a new AccountReceivable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-account-receivable')){
            $model      = new AccountReceivable();          
            $dataList   = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');           

            $model->date_issued = time();

            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($model->accountReceivableDetails);
            }        

            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'dataList'=>$dataList,
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }        
    }

    /**
     * Updates an existing AccountReceivable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-account-receivable')){
            $model      = $this->findModel($id);      
            $dataList   = ArrayHelper::map(Staff::find()->where(['active_status'=>Staff::ACTIVE_STATUS_YES])->asArray()->all(), 'id','title');
                        
            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'dataList'=>$dataList,
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }           
    }

    /**
     * Deletes an existing AccountReceivable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        if(Yii::$app->user->can('delete-account-receivable')){
            $this->findModel($id)->deleteWithRelated();

            return $this->redirect(['index']);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }                  
        
    }
    
    /**
     * 
     * Export AccountReceivable information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerAccountReceivableDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->accountReceivableDetails,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerAccountReceivableDetail' => $providerAccountReceivableDetail,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    
    /**
     * Finds the AccountReceivable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountReceivable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountReceivable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for AccountReceivableDetail
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddAccountReceivableDetail()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('AccountReceivableDetail');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formAccountReceivableDetail', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
