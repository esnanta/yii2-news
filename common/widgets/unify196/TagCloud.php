<?php
namespace common\widgets\unify196;

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
            $link = Html::a($tag, Yii::$app->getUrlManager()->createUrl(['blog/index','tag'=>$tag]),['class'=>'']);
            $str .= Html::tag('li', $link, [
                    //'class'=>'round-4x',
                    //'style'=>"font-size:{$weight}pt",
                ]);
        }

        return $this->render('_unify196_tag', [
            'title' => $this->title,
            'content' => $str,
        ]);
    }
}