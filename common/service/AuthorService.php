<?php
namespace common\service;

use common\models\Article;
use common\models\Author;
use yii\db\Expression;

class AuthorService
{
    public function getRandomAuthors(int $limit = 3): array
    {
        return Author::find()->limit(5)
            ->where(['<>','id','1'])
            ->orderBy((new Expression('rand()')))->all();
    }
}