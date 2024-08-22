<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleCategory;
use common\models\ArticleSearch;
use common\service\DataListService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class ArticleController extends Controller
{

    public $layout = "/column2_blog";


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
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
                'quality' => 100,
                'maxWidth' => 900,
                'maxHeight' => 900,
                'useHash' => true,
                'url' => '@web/uploads/article/',
                'path' => '@backend/web/uploads/article/',
            ],
            'upload-images' => [
                'class' => 'backend\editor\UploadAction',
                'quality' => 100,
                'maxWidth' => 900,
                'maxHeight' => 900,
                'useHash' => true,
                'url' => '@web/uploads/article/',
                'path' => '@backend/web/uploads/article/',
            ],
        ];
    }

    public function actionIndex($cat=null,$title=null)
    {

        $searchModel = new ArticleSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('publish_status = '.Article::PUBLISH_STATUS_YES);
        $dataProvider->pagination->pageSize = 10;
        $dataProvider->setSort([
            'defaultOrder' => [
                'date_issued' => SORT_DESC,
            ]
        ]);

        if(!empty($cat)){
            $dataProvider->query->andWhere('article_category_id = '.$cat);
        }

        if(Yii::$app->request->get('tag')){
            $dataProvider->query->andFilterWhere([
                    'like', 'tags', Yii::$app->request->get('tag'),
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel
        ]);
    }

    public function actionTimeLine()
    {

        $searchModel = new ArticleSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('publish_status = '.Article::PUBLISH_STATUS_YES);
        $dataProvider->query->andWhere('tx_category.time_line = '.ArticleCategory::TIME_LINE_YES);

        $dataProvider->pagination->pageSize = 10;
        $dataProvider->setSort([
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ]
        ]);

        if(Yii::$app->request->get('tag')){
            $dataProvider->query->andFilterWhere([
                    'like', 'tags', Yii::$app->request->get('tag'),
            ]);
        }

        return $this->render('timeline', [
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel
        ]);
    }
    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        $model          = $this->findModel($id);

        $authorList     = DataListService::getAuthor();
        $categoryList   = DataListService::getArticleCategory();
        $publishList    = Article::getArrayPublishStatus();
        $pinnedList     = Article::getArrayPinnedStatus();

        $model->view_counter    = $model->view_counter+1;
        $model->save();

        return $this->render('view', [
            'model' => $model,
            'authorList'=>$authorList,
            'categoryList'=>$categoryList,
            'publishList'=>$publishList,
            'pinnedList'=>$pinnedList
        ]);

    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
