<?php

namespace frontend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductImage;
use backend\models\ProductFeature;
use backend\models\ProductDetail;
use backend\models\ProductType;
use backend\models\Measure;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use yii\data\ArrayDataProvider;
/**
 * ProductController implements the CRUD actions for Product model.
 */
class PortfolioController extends Controller
{
    
    public $layout = "/column2_portfolio";
    
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $productTypes    = ProductType::find()->all();
        $products        = Product::find()->all();

        return $this->render('index', [
            'productTypes' => $productTypes,
            'products' => $products,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $product = $this->findModel($id);
        
        $providerPricing = new ArrayDataProvider([
            'allModels' => $product->pricings,
            'pagination' => [
                    'pagesize' => 24,
            ],  
            'sort' => [
                'attributes' => ['sequence'],
                'defaultOrder' => ['sequence' => SORT_ASC]
            ],               
        ]);        

        $providerProductImage = new ArrayDataProvider([
            'allModels' => $product->productImages,
            'pagination' => [
                    'pagesize' => 24,
            ],  
            'sort' => [
                'attributes' => ['created_at'],
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],               
        ]);  
        
        
        return $this->render('view', [
            'product' => $product,
            'providerPricing'=>$providerPricing,
            'providerProductImage'=>$providerProductImage
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model              = new Product;
        $measureList        = ArrayHelper::map(Measure::find()->asArray()->all(), 'id','title');
        $productTypeList    = ArrayHelper::map(ProductType::find()->asArray()->all(), 'id','title');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'measureList'=>$measureList,
                'productTypeList'=>$productTypeList                
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model              = $this->findModel($id);
        $measureList        = ArrayHelper::map(Measure::find()->asArray()->all(), 'id','title');
        $productTypeList    = ArrayHelper::map(ProductType::find()->asArray()->all(), 'id','title');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'measureList'=>$measureList,
                'productTypeList'=>$productTypeList
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
