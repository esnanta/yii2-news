<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use backend\models\Author;
use backend\models\AuthorSearch;
use backend\models\Blog;
use backend\models\Category;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    public $layout = "/column1";
    
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
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthorSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Author model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$title=null,$cat=null)
    {
        $model          = $this->findModel($id);
        $categories     = Category::find()->all();
        $categoryTitle  = 'All';
        
        /**
         * B L O G S
         */
        $blogQuery = Blog::find()->where([
            'publish_status' => Blog::PUBLISH_STATUS_YES,
            'author_id' => $model->id
        ]);

        $blogProvider = new ActiveDataProvider([
            'query' => $blogQuery,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);        
        
        if(!empty($cat)){
            $category = Category::find()->where(['id'=>$cat])->one();
            $categoryTitle = $category->title;
            $blogProvider->query->andWhere(['category_id'=> $cat]);
        }
        
        $blogProvider->pagination->pageSize=6;        
                
        
        $oldFile = $model->getImageFile();
        $oldAvatar = $model->file_name;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->file_name = $oldAvatar;
                //$model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) { // delete old and overwrite
                    file_exists($oldFile) ? unlink($oldFile) : '' ;
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect([
                    'view', 
                    'id'=>$model->id,
                ]);
            } else {
                // error in saving model
            }
        }        
        else {
            return $this->render('view', [
                'model'         => $model,
                'blogProvider'  => $blogProvider,
                'categories'    => $categories,
                'categoryTitle' => $categoryTitle,
            ]);
        }        
        
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Author;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();    
            
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('create', [
            'model'=>$model,
        ]);          
        
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        
        $oldFile = $model->getImageFile();
        $oldAvatar = $model->file_name;
        $oldFileName = $model->title;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->file_name = $oldAvatar;
                //$model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) { // delete old and overwrite
                    file_exists($oldFile) ? unlink($oldFile) : '' ;
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model'=>$model,
        ]);         

    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // validate deletion and on failure process any exception 
        // e.g. display an error message 
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
