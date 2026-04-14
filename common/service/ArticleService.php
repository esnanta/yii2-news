<?php

namespace common\service;

use common\models\Article;
use yii\db\Expression;

class ArticleService
{
    public function getLatestArticles(int $limit = 5): array
    {
        return Article::find()->published()->limit($limit)
            ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_DESC])->all()
        ;
    }

    public function getLatestArticlesByOffset(int $limit = 5, int $offset = 5): array
    {
        return Article::find()->published()->limit($limit)->offset($offset)
            ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_DESC])->all()
        ;
    }

    public function getPinnedArticles(int $limit = 3): array
    {
        return Article::find()->published()->limit($limit)
            ->andWhere(['is_pinned' => 1])
            ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_DESC])->all()
        ;
    }

    public function getPopularArticles(int $limit = 2, int $counter = 100): array
    {
        return Article::find()->published()->limit($limit)
            ->andWhere(['>', 'view_count', $counter])
            // ->andWhere(['between','view_counter','10','199'])
            ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_DESC])->all()
        ;
    }

    public function getRandomArticles(int $limit = 3): array
    {
        return Article::find()->published()->limit($limit)
            ->orderBy(new Expression('rand()'))->all()
        ;
    }
}
