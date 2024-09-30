<?php
namespace common\service;

use common\models\Article;
use yii\db\Expression;

class ArticleService
{
    public function getLatestArticles(int $limit = 5): array
    {
        return Article::find()->limit($limit)
            ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
            ->orderBy(['date_issued' => SORT_DESC])->all();
    }

    //EXAMPLE : SELECT * FROM tbl_table LIMIT 5,10;  # Retrieve rows 6-15
    public function getLatestArticlesByOffset(int $limit = 5, int $offset=5): array
    {
        return Article::find()->limit($limit)->offset($offset)
            ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
            ->orderBy(['date_issued'=>SORT_DESC])->all();
    }

    public function getPinnedArticles(int $limit = 3): array
    {
        return Article::find()->limit($limit)
            ->where([
                'publish_status' => Article::PUBLISH_STATUS_YES,
                'pinned_status' => Article::PINNED_STATUS_YES
            ])
            ->orderBy(['date_issued'=>SORT_DESC])->all();
    }

    public function getPopularArticles(int $limit = 2, int $counter = 100): array
    {
        return Article::find()->limit($limit)
            ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
            ->andWhere(['>','view_counter', $counter])
            //->andWhere(['between','view_counter','10','199'])
            ->orderBy(['date_issued'=>SORT_DESC])->all();
    }

    public function getRandomArticles(int $limit = 3): array
    {
        return Article::find()->limit($limit)
            ->where([
                'publish_status' => Article::PUBLISH_STATUS_YES,
            ])
            ->orderBy((new Expression('rand()')))->all();
    }
}