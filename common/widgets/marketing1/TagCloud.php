<?php
namespace common\widgets\marketing1;

use Yii;
use backend\models\Tag as Tag;
use yii\base\Widget;
use yii\helpers\Html;

class TagCloud extends Widget
{
    public $title;
    public $maxTags = 20;

    public function init()
    {
        parent::init();

        if ($this->title === null) {
            $this->title = 'title';
        }
    }

    public function run()
    {
        $tags = Tag::findTagWeights();
        $str = '';
        foreach($tags as $tag=>$weight)
        {
            $link = Html::a($tag, Yii::$app->getUrlManager()->createUrl(['blog/index','tag'=>$tag]),['class'=>'u-link-v5 g-brd-around g-brd-gray-light-v4 g-bg-secondary g-color-text g-color-main--hover g-bg-primary--hover g-font-weight-500 g-font-size-13 rounded g-px-20 g-py-8']);
        }

        return $this->render('_tags', [
            'title' => $this->title,
            'link' => $link,
        ]);
    }
}