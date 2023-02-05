<?php
namespace common\widgets\blogunify236;

use Yii;
use backend\models\Tag as Tag;
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
                        ->createUrl(['blog/index','tag'=>$tag]),['class'=>'u-tags-v1 g-brd-around g-brd-gray-light-v4 g-bg-primary--hover g-brd-primary--hover g-color-black-opacity-0_8 g-color-white--hover rounded g-py-6 g-px-15']);

            $str .= Html::tag('li', $link, [
                    'class'=>'list-inline-item g-mb-10',
                    //'style'=>"font-size:{$weight}pt",
                ]);
        }

        return $this->render('_tag', [
            'title' => $this->title,
            'content' => $str,
        ]);
    }
}