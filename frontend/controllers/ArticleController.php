<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\ArticleCategory;
use frontend\models\search\ArticleSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    private const POSTS_PER_PAGE = 3;
    private const ARCHIVE_MONTHS_COUNT = 12;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['is_pinned' => SORT_DESC, 'published_at' => SORT_DESC],
        ];
        $dataProvider->pagination = [
            'pageSize' => self::POSTS_PER_PAGE,
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'archive' => Article::find()->getFullArchive()->limit(self::ARCHIVE_MONTHS_COUNT)->asArray()->all(),
            'categories' => ArticleCategory::find()->getCategoriesUsage()->asArray()->all(),
        ]);
    }

    /**
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Article::find()->published()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }

        // Keep this atomic to avoid race conditions on concurrent reads.
        $model->updateCounters(['view_count' => 1]);
        ++$model->view_count;

        $viewFile = $model->view ?: 'view';

        return $this->render($viewFile, [
            'model' => $model,
            'archive' => Article::find()->getFullArchive()->limit(self::ARCHIVE_MONTHS_COUNT)->asArray()->all(),
            'categories' => ArticleCategory::find()->getCategoriesUsage()->asArray()->all(),
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionAttachmentDownload($id): Response
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return \Yii::$app->response->sendStreamAsFile(
            \Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }
}
