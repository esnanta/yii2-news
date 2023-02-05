<?php

namespace frontend\controllers;

use Yii;
use backend\models\Page as Page;
use backend\models\PageSearch as PageSearch;
use backend\models\PageType as PageType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    public $layout = "/column2";
    
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
    
    public function actions() {

        return [
            'browse-images' => [
                'class' => 'backend\editor\BrowseAction',
                'quality' => 80,
                'maxWidth' => 800,
                'maxHeight' => 800,
                'useHash' => true,
                'url' => '@web/uploads/page/',
                'path' => '@backend/web/uploads/page/',
            ],
            'upload-images' => [
                'class' => 'backend\editor\UploadAction',
                'quality' => 80,
                'maxWidth' => 800,
                'maxHeight' => 800,
                'useHash' => true,
                'url' => '@web/uploads/page/',
                'path' => '@backend/web/uploads/page/',
            ],
        ];
    }    

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel    = new PageSearch;
        $dataProvider   = $searchModel->search(Yii::$app->request->getQueryParams());
        $pageTypeList   = ArrayHelper::map(PageType::find()->asArray()->all(), 'id','title');
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'pageTypeList'=>$pageTypeList
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model          = $this->findModel($id);
        $pageTypeList   = ArrayHelper::map(PageType::find()->asArray()->all(), 'id','title');
        
        $model->view_counter = $model->view_counter+1;
        $model->save();        
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'pageTypeList'=>$pageTypeList
            ]);
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
