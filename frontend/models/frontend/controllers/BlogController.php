<?php

namespace frontend\controllers;

use Yii;
use backend\models\Blog;
use backend\models\BlogSearch;
use backend\models\Tag;
use backend\models\Lookup;
use backend\models\Category;
use backend\models\Author;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; // load classes

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    public $layout = "/column2_blog";
    
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
                'url' => '@web/uploads/blog/',
                'path' => '@backend/web/uploads/blog/',
            ],
            'upload-images' => [
                'class' => 'backend\editor\UploadAction',
                'quality' => 80,
                'maxWidth' => 800,
                'maxHeight' => 800,
                'useHash' => true,
                'url' => '@web/uploads/blog/',
                'path' => '@backend/web/uploads/blog/',
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    
    
//    public function actionIndex()
//    {
//        $query = BlogPost::find();
//        $query->where([
//            'status' => Status::STATUS_ACTIVE,
//        ]);
//
//        if(Yii::$app->request->get('tag')){
//            $query->andFilterWhere([
//                'like', 'tags', Yii::$app->request->get('tag'),
//            ]);
//        }
////        if(Yii::$app->request->get('keyword'))
////        {
////            $keyword = strtr(Yii::$app->request->get('keyword'), array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\'));
////            $keyword = Yii::$app->formatter->asText($keyword);
////
////            $query->andFilterWhere([
////                'or', ['like', 'title', $keyword], ['like', 'content', $keyword]
////            ]);
////        }
//
//        $pagination = new Pagination([
//            'defaultPageSize' => Yii::$app->params['blogPostPageCount'],
//            'totalCount' => $query->count(),
//        ]);
//
//        $posts = $query->orderBy('created_at desc')
//            ->offset($pagination->offset)
//            ->limit($pagination->limit)
//            ->all();
//
//        return $this->render('index', [
//            'posts' => $posts,
//            'pagination' => $pagination,
//        ]);
//    }    
    
    
    
    public function actionIndex()
    {

        $searchModel = new BlogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('publish_status = '.Lookup::getId(Yii::$app->params['LookupToken_Publish']));
        $dataProvider->pagination->pageSize = 10;
        $dataProvider->setSort([
            'defaultOrder' => [
                'create_time' => SORT_DESC,
            ]            
        ]);        

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

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $author = Author::find()->where(['id'=>$model->author_id])->one();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            
            $model->view_counter = $model->view_counter+1;
            $model->save();
            return $this->render('view', [
                'model' => $model,
                'author'=>$author,
            ]);
        }
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog;

        $tagList        =ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
        $authorList     =ArrayHelper::map(Author::find()->asArray()->all(), 'id','title');
        $categoryList   =ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');
        $publishList    =ArrayHelper::map(Lookup::find()->where(['category' => Yii::$app->params['LookupCategory_DraftPublish']])->asArray()->all(), 'id','title');
        $pinnedList     =ArrayHelper::map(Lookup::find()->where(['category' => Yii::$app->params['LookupCategory_YesNo']])->asArray()->all(), 'id','title');        
                
        
        if ($model->load(Yii::$app->request->post())) {
            
            if (is_array($model->tags)) {
                $model->tags = implode(', ', $model->tags);
            }               
            
            if($model->save()){

                return $this->redirect(['view', 'id' => $model->blog_id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'tagList'=>$tagList,
                'authorList'=>$authorList,
                'categoryList'=>$categoryList,
                'publishList'=>$publishList,
                'pinnedList'=>$pinnedList,                   
            ]);
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $tagList        =ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
        $authorList     =ArrayHelper::map(Author::find()->asArray()->all(), 'id','title');
        $categoryList   =ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');
        $publishList    =ArrayHelper::map(Lookup::find()->where(['category' => Yii::$app->params['LookupCategory_DraftPublish']])->asArray()->all(), 'id','title');
        $pinnedList     =ArrayHelper::map(Lookup::find()->where(['category' => Yii::$app->params['LookupCategory_YesNo']])->asArray()->all(), 'id','title');        
                
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->blog_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tagList'=>$tagList,
                'authorList'=>$authorList,
                'categoryList'=>$categoryList,
                'publishList'=>$publishList,
                'pinnedList'=>$pinnedList,                    
            ]);
        }
    }

    /**
     * Deletes an existing Blog model.
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
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
