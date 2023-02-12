<?php

namespace backend\controllers;

use Yii;
use backend\models\Blog;
use backend\models\Tag;
use backend\models\Category;
use backend\models\Author;
use backend\models\BlogSearch;

use common\helper\Helper;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
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

    
    public function actions() {

        return [
            'browse-images' => [
                'class' => 'backend\editor\BrowseAction',
                'quality' => 100,
                'maxWidth' => 900,
                'maxHeight' => 900,
                'useHash' => true,
                'url' => '@web/uploads/blog/',
                'path' => '@backend/web/uploads/blog/',
            ],
            'upload-images' => [
                'class' => 'backend\editor\UploadAction',
                'quality' => 100,
                'maxWidth' => 900,
                'maxHeight' => 900,
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
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-blog')){
            $searchModel = new BlogSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $authorList     =ArrayHelper::map(Author::find()->asArray()->all(), 'id','title');
            $categoryList   =ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');
            $publishList    =Blog::getArrayPublishStatus();
            $pinnedList     =Blog::getArrayPinnedStatus();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'authorList'=>$authorList,
                'categoryList'=>$categoryList,
                'publishList'=>$publishList,
                'pinnedList'=>$pinnedList,
            ]);            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }  
        
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-blog')){
            $model = $this->findModel($id);

            $tagList        = ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
            $authorList     = ArrayHelper::map(Author::find()->asArray()->all(), 'id','title');
            $categoryList   = ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');
            $publishList    = Blog::getArrayPublishStatus();
            $pinnedList     = Blog::getArrayPinnedStatus();

            $tagsVal        = explode(',',$model->tags);//split as array

            foreach($tagsVal as $key => $val) {
                $new[$val]=$val;
            }

            //$tagsFlip       = $tagsVal; 
            $tagsFlip       = $new; 

            //$tagsFlip       = array_flip($tagsVal); //reverse key =>value        

            //$tagsFlip       = ['0'=>'0','1'=>'1','2'=>'2']; //reverse key =>value        

            if ($model->load(Yii::$app->request->post())) {
                if (is_array($model->tags)) {
                    $model->tags = implode(', ', $model->tags);
                }               

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('view', [
                    'model'         =>$model,
                    'tagsFlip'      =>$tagsFlip,
                    'tagList'       =>$tagList,
                    'authorList'    =>$authorList,
                    'categoryList'  =>$categoryList,
                    'publishList'   =>$publishList,
                    'pinnedList'    =>$pinnedList, 
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }                
            
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-blog')){
            $model              = new Blog;
            $model->date_issued = time();
            
            $tagList        =ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
            $authorList     =ArrayHelper::map(Author::find()->asArray()->all(), 'id','title');
            $categoryList   =ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');

            if ($model->load(Yii::$app->request->post())) {
                $test = $model->tags;
                if (is_array($model->tags)) {
                    $model->tags = implode(', ', $model->tags);
                }               

                if($model->save()){

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'tagList'=>$tagList,
                    'authorList'=>$authorList,
                    'categoryList'=>$categoryList,                
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
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
        if(Yii::$app->user->can('update-blog')){
            $model = $this->findModel($id);

            $tagList        =ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
            $authorList     =ArrayHelper::map(Author::find()->asArray()->all(), 'id','title');
            $categoryList   =ArrayHelper::map(Category::find()->asArray()->all(), 'id','title');

            $tagsVal        =explode(',',$model->tags);//split as array
            $tagsFlip       =array_flip($tagsVal); //reverse key =>value       

            if ($model->load(Yii::$app->request->post())) {

                if (is_array($model->tags)) {
                    $model->tags = implode(', ', $model->tags);
                }   

                if($model->save()){

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('update', [
                    'model'         =>$model,
                    'tagsFlip'      =>$tagsFlip,
                    'tagList'       =>$tagList,
                    'authorList'    =>$authorList,
                    'categoryList'  =>$categoryList,               
                ]);
            }            
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
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
        if(Yii::$app->user->can('delete-blog')){
            $transaction = \Yii::$app->db->beginTransaction();
            try {  
                $model = $this->findModel($id);
                $model->deleteImage();
                $model->delete();
                $transaction->commit();
                return $this->redirect(['index']);  
            } 
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } 
            catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }        
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }
    }

    public function actionPublish($id){
        
        $model = $this->findModel($id);
        $model->publish_status = ($model->publish_status == Blog::PUBLISH_STATUS_NO) ? 
                Blog::PUBLISH_STATUS_YES : Blog::PUBLISH_STATUS_NO;
        $model->save();
        
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionPinned($id){
        
        $model = $this->findModel($id);
        $model->pinned_status = ($model->pinned_status == Blog::PINNED_STATUS_NO) ? 
                Blog::PINNED_STATUS_YES : Blog::PINNED_STATUS_NO;
        $model->save();
        
        return $this->redirect(['view', 'id' => $model->id]);
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
