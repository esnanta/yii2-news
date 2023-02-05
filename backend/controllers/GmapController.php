<?php

namespace backend\controllers;

use Yii;
use backend\models\Gmap;
use backend\models\GmapSearch;
use backend\models\Customer;
use backend\models\Office;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use kartik\widgets\ActiveForm;

/**
 * GmapController implements the CRUD actions for Gmap model.
 */
class GmapController extends Controller
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
     * Lists all Gmap models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-gmap')){
            $searchModel = new GmapSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $customerList       = Customer::getArrayList();

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'customerList'=>$customerList,
            ]);       
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         

    }

    /**
     * Displays a single Gmap model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('view-gmap')){
            $model              = $this->findModel($id);
            $office             = Office::find()->where(['id'=>1])->one();
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');

            $providerGmapDetail = new \yii\data\ArrayDataProvider([
                'allModels' => $model->gmapDetails,
            ]);
            return $this->render('view', [
                'model' => $this->findModel($id),
                'providerGmapDetail' => $providerGmapDetail,
                'customerList'=>$customerList,
                'office'=>$office
            ]);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          
        
    }

    /**
     * Creates a new Gmap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {    
        if(Yii::$app->user->can('create-gmap')){
            $model              = new Gmap();
            $model->customer_id = $id;
            
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');

            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON; 
                return ActiveForm::validate($model);
            }              

            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'customerList'=>$customerList
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }         
        
    }

    /**
     * Updates an existing Gmap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        if(Yii::$app->user->can('update-gmap')){
            $model              = $this->findModel($id);
            $customerList       = ArrayHelper::map(Customer::find()->where(['id'=>$model->customer_id])->asArray()->all(), 'id','title');

            if (Yii::$app->request->isAjax && $model->loadAll(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON; 
                return ActiveForm::validate($model);
            }           

            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'customerList'=>$customerList
                ]);
            }           
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          
        
    }

    /**
     * Deletes an existing Gmap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-gmap')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }          

    }
    
    /**
     * 
     * Export Gmap information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerGmapDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->gmapDetails,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerGmapDetail' => $providerGmapDetail,
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
     * Finds the Gmap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gmap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gmap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for GmapDetail
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddGmapDetail()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('GmapDetail');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formGmapDetail', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
