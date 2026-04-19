<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleCategory;
use common\models\Author;
use common\models\search\AuthorSearch;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    public $layout = '/column1';

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

    /**
     * Lists all Author models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Author model.
     *
     * @param int        $id
     * @param null|mixed $title
     * @param null|mixed $cat
     *
     * @return mixed
     */
    public function actionView($id, $title = null, $cat = null)
    {
        $model = $this->findModel($id);
        $categories = ArticleCategory::find()->all();
        $categoryTitle = 'All';

        /**
         * B L O G S.
         */
        $blogQuery = Article::find()->where([
            'status' => Article::STATUS_PUBLISHED,
            'author_id' => $model->id,
        ]);

        $blogProvider = new ActiveDataProvider([
            'query' => $blogQuery,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if (!empty($cat)) {
            $category = ArticleCategory::find()->where(['id' => $cat])->one();
            $categoryTitle = $category->title;
            $blogProvider->query->andWhere(['article_category_id' => $cat]);
        }

        $blogProvider->pagination->pageSize = 6;

        $oldFile = $model->getAssetFile();
        $oldAvatar = $model->file_name;

        if ($model->load(\Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if (false === $image) {
                $model->file_name = $oldAvatar;
                // $model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if (false !== $image) { // delete old and overwrite
                    file_exists($oldFile) ? unlink($oldFile) : '';
                    $path = $model->getAssetFile();
                    $image->saveAs($path);
                }

                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            }
        // error in saving model
        } else {
            return $this->render('view', [
                'model' => $model,
                'blogProvider' => $blogProvider,
                'categories' => $categories,
                'categoryTitle' => $categoryTitle,
            ]);
        }
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Author();

        if ($model->load(\Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if (false !== $image) {
                    $path = $model->getAssetFile();
                    $image->saveAs($path);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            // error in saving model
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $oldFile = $model->getAssetFile();
        $oldAvatar = $model->file_name;
        $oldFileName = $model->title;

        if ($model->load(\Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if (false === $image) {
                $model->file_name = $oldAvatar;
                // $model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if (false !== $image) { // delete old and overwrite
                    file_exists($oldFile) ? unlink($oldFile) : '';
                    $path = $model->getAssetFile();
                    $image->saveAs($path);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            // error in saving model
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteAsset()) {
                \Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Author the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
