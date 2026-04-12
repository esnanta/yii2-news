<?php

namespace common\widgets\bootstrap4news;

use common\models\Tag;
use yii\base\Widget;
use yii\helpers\Html;

class TagCloud extends Widget
{
    public $title;
    public $maxTags = 8;

    public function init()
    {
        parent::init();

        if (null === $this->title) {
            $this->title = 'title';
        }
    }

    public function run()
    {
        $tags = Tag::findTagWeights($this->maxTags);
        $str = '';
        foreach ($tags as $tagData) {
            $title = (string) ($tagData['title'] ?? '');
            if ('' === $title) {
                continue;
            }

            $slug = (string) ($tagData['slug'] ?? '');
            $link = Html::a(
                Html::encode($title),
                \Yii::$app->getUrlManager()->createUrl(['article/index', 'tag' => '' !== $slug ? $slug : $title])
            );

            $str .= $link.' ';
        }

        return $this->render('_tag', [
            'title' => $this->title,
            'content' => $str,
        ]);
    }
}
