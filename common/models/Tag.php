<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "tx_tag".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $frequency
 */
class Tag extends \common\models\base\Tag
{
    
    public static function string2array($tags)
    {
        return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags)
    {
        return implode(',',$tags);
    }

    public static function updateFrequency($oldTags, $newTags)
    {
        $oldTags = self::string2array($oldTags);
        $newTags = self::string2array($newTags);
        self::addTags(array_values(array_diff($newTags, $oldTags)));
        self::removeTags(array_values(array_diff($oldTags, $newTags)));
    }

    public static function updateFrequencyOnDelete($oldTags)
    {
        $oldTags = self::string2array($oldTags);
        self::removeTags($oldTags);
    }

    public static function addTags($tags)
    {

        Tag::updateAllCounters(['frequency' => 1], 'tag_name in ("' . implode ( '"," ', $tags) . '")');

        foreach($tags as $name)
        {
            if(!Tag::findOne(['tag_name' => $name,]))
            {
                $tag = new Tag;
                $tag->tag_name = $name;
                $tag->frequency = 1;
                $tag->save();
            }
        }
    }

    public static function removeTags($tags)
    {
        if(empty($tags))
            return;
        Tag::updateAllCounters(['frequency' => 1], 'tag_name in ("' . implode ( '"," ', $tags) . '")');
        Tag::deleteAll('frequency <= 0');
    }

    public static function findTagWeights($limit=20)
    {
        $models = Tag::find()->limit($limit)->orderBy(['frequency' => SORT_DESC])->all();

        $total = 0;
        foreach($models as $model){
            $total += $model->frequency;
        }

        $tags = [];
        if($total>0)
        {
            foreach($models as $model)
                $tags[$model->tag_name] = 8 + (int)(16*$model->frequency/($total+10));
            ksort($tags);
        }
        return $tags;
    }

    public static function getTagLinks($tags,$class=null): array
    {
        $links = [];
        foreach(Tag::string2array($tags) as $tag){
            if($class==null){
                $links[] = Html::a($tag,
                    Yii::$app->getUrlManager()->createUrl(['article/index', 'tag'=>$tag]));
            }
            else{
                $links[] = Html::a('<span class="'.$class.'">'.$tag.'</span>',
                    Yii::$app->getUrlManager()->createUrl(['article/index', 'tag'=>$tag]));
            }
        }
        return $links;
    }
}
