<?php

namespace common\widgets\bootstrap4news;

use common\models\Article;
use yii\base\Widget;

class RecentArticles extends Widget
{
    public $title;
    public $maxData = 5;

    public function init()
    {
        parent::init();

        if (null === $this->title) {
            $this->title = 'title';
        }
    }

    public function run()
    {
        $articleList = Article::find()
            ->where(['status' => Article::STATUS_PUBLISHED])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($this->maxData)->all()
        ;

        return $this->render('_recent_article', [
            'title' => $this->title,
            'articleList' => $articleList,
        ]);
    }
}
