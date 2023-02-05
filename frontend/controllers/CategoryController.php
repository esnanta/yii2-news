<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use backend\models\Blog;
use backend\models\BlogSearch;
use backend\models\Category;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
//    public $layout = "/column2_blog";

    public function actionTimeLine() {

        $searchModel = new BlogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('publish_status = ' . Blog::PUBLISH_STATUS_YES);
        $dataProvider->query->andWhere('tx_category.time_line = ' . Category::TIME_LINE_YES);

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
