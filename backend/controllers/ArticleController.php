<?php

namespace backend\controllers;

use common\helper\DateHelper;
use common\helper\MessageHelper;
use common\models\Article;
use common\models\ArticleSearch;
use common\models\Tag;
use common\service\CacheService;
use common\service\DataListService;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class ArticleController extends Controller
{
    public function behaviors(): array
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

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('index-article')){
            $searchModel = new ArticleSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $authorList             = DataListService::getAuthor();
            $articleCategoryList    = DataListService::getArticleCategory();
            $publishList            = Article::getArrayPublishStatus();
            $pinnedList             = Article::getArrayPinnedStatus();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'authorList' => $authorList,
                'articleCategoryList' => $articleCategoryList,
                'publishList' => $publishList,
                'pinnedList' => $pinnedList,
            ]);            
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException|Exception
     */
    public function actionView($id,$title=null)
    {
        if(Yii::$app->user->can('view-article')){
            $model = $this->findModel($id);

            $tagList                = ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
            $authorList             = DataListService::getAuthor();
            $articleCategoryList    = DataListService::getArticleCategory();
            $publishList            = Article::getArrayPublishStatus();
            $pinnedList             = Article::getArrayPinnedStatus();

            // Split the tags string into an array
            $tagsVal = explode(',', $model->tags);
            // Optionally trim the tags to remove any spaces
            // Ensure the values are clean
            $articleTags = array_map('trim', $tagsVal);

            if ($model->load(Yii::$app->request->post())) {
                return $this->validateAndSave($model);
            } else {
                return $this->render('view', [
                    'model'         =>$model,
                    'articleTags'   =>$articleTags,
                    'tagList'       =>$tagList,
                    'authorList'    =>$authorList,
                    'articleCategoryList' => $articleCategoryList,
                    'publishList'   =>$publishList,
                    'pinnedList'    =>$pinnedList, 
                ]);
            }            
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-article')){
            $model              = new Article;
            $model->office_id   = CacheService::getInstance()->getOfficeId();
            $model->date_issued = date(DateHelper::getDateSaveFormat());
            
            $tagList                = ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
            $authorList             = DataListService::getAuthor();
            $articleCategoryList    = DataListService::getArticleCategory();

            if ($model->load(Yii::$app->request->post())) {
                return $this->validateAndSave($model);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'tagList'=>$tagList,
                    'authorList'=>$authorList,
                    'articleCategoryList' => $articleCategoryList,
                ]);
            }            
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('update-article')){
            $model = $this->findModel($id);

            $tagList                = ArrayHelper::map(Tag::find()->asArray()->all(), 'tag_name','tag_name');
            $authorList             = DataListService::getAuthor();
            $articleCategoryList    = DataListService::getArticleCategory();

            $tagsVal        =explode(',',$model->tags);//split as array
            $tagsFlip       =array_flip($tagsVal); //reverse key =>value       

            if ($model->load(Yii::$app->request->post())) {

                return $this->validateAndSave($model);
            } else {
                return $this->render('update', [
                    'model'         =>$model,
                    'tagsFlip'      =>$tagsFlip,
                    'tagList'       =>$tagList,
                    'authorList'    =>$authorList,
                    'articleCategoryList' => $articleCategoryList,
                ]);
            }            
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('delete-article')){
            $transaction = \Yii::$app->db->beginTransaction();
            try {  
                $model = $this->findModel($id);
                $model->deleteImage();
                $model->delete();
                $transaction->commit();
                MessageHelper::getFlashDeleteSuccess();
                return $this->redirect(['index']);  
            } 
            catch (\Exception|\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        else{
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    public function actionPublish($id): Response
    {
        
        $model = $this->findModel($id);
        $model->publish_status = ($model->publish_status == Article::PUBLISH_STATUS_NO) ?
                Article::PUBLISH_STATUS_YES : Article::PUBLISH_STATUS_NO;
        $model->save();
        
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionPinned($id): Response
    {
        
        $model = $this->findModel($id);
        $model->pinned_status = ($model->pinned_status == Article::PINNED_STATUS_NO) ?
                Article::PINNED_STATUS_YES : Article::PINNED_STATUS_NO;
        $model->save();
        
        return $this->redirect(['view', 'id' => $model->id]);
    }    

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Article
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param Article $model
     * @return Response
     * @throws Exception
     */
    private function validateAndSave(Article $model): Response
    {
        if (is_array($model->tags)) {
            $model->tags = implode(', ', $model->tags);
        }

        if ($model->validate() && $model->save()) {
            MessageHelper::getFlashSaveSuccess();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            MessageHelper::getFlashImageExceed();
            return $this->redirect(['view', 'id' => $model->id, 'edit' => 't']);
        }
    }
}
