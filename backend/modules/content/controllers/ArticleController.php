<?php

namespace backend\modules\content\controllers;

use common\base\BaseController;
use backend\modules\content\models\search\ArticleSearch;
use common\models\Article;
use common\models\ArticleCategory;
use common\service\DataListService;
use common\traits\FormAjaxValidationTrait;
use yii\base\ExitException;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ArticleController extends BaseController
{
    use FormAjaxValidationTrait;

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
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'authorOptions' => DataListService::getAuthor(),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $article = new Article();

        $this->performAjaxValidation($article);

        if ($article->load(\Yii::$app->request->post()) && $article->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $article,
            'categories' => ArticleCategory::find()->active()->all(),
        ]);
    }

    /**
     * @return mixed
     *
     * @throws ExitException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int $id)
    {
        $article = $this->findModel($id);

        $this->performAjaxValidation($article);

        if ($article->load(\Yii::$app->request->post()) && $article->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $article,
            'categories' => ArticleCategory::find()->active()->all(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return Article the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Article
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
