<?php
namespace common\widgets\bootstrap4news;

use Yii;
use common\models\Tag as Tag;
use yii\base\Widget;
use yii\helpers\Html;

class TagCloud extends Widget
{
    public $title;
    public $maxTags = 8;

    public function init()
    {
        parent::init();

        if ($this->title === null) {
            $this->title = 'title';
        }
    }

    public function run()
    {
        $tags = Tag::findTagWeights($this->maxTags);
        $str = '';
        foreach($tags as $tag=>$weight)
        {
            $link = Html::a($tag, Yii::$app->getUrlManager()
                        ->createUrl(['article/index','tag'=>$tag]));

            $str .= $link.' ';
        }

        return $this->render('_tag', [
            'title' => $this->title,
            'content' => $str,
        ]);
    }
}