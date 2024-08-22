<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use common\models\Article;
use common\models\ArticleSearch;
use common\models\ArticleCategory;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ArticleCategoryController extends Controller
{
    public $layout = "/column1";

    public function actionTimeLine() {

        $searchModel = new ArticleSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('publish_status = ' . Article::PUBLISH_STATUS_YES);
        $dataProvider->query->andWhere('tx_category.time_line = ' . ArticleCategory::TIME_LINE_YES);

        $dataProvider->pagination->pageSize = 10;
        $dataProvider->setSort([
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ]
        ]);

        if (Yii::$app->request->get('tag')) {
            $dataProvider->query->andFilterWhere([
                'like', 'tags', Yii::$app->request->get('tag'),
            ]);
        }

        return $this->render('timeline', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }

}
