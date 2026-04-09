<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%article_attachment}}".
 *
 * @property int     $id
 * @property int     $article_id
 * @property string  $base_url
 * @property string  $path
 * @property string  $url
 * @property string  $name
 * @property string  $type
 * @property string  $size
 * @property int     $order
 * @property Article $article
 */
class ArticleAttachment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%article_attachment}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['article_id', 'path'], 'required'],
            [['article_id', 'size', 'order'], 'integer'],
            [['base_url', 'path', 'type', 'name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'article_id' => \Yii::t('common', 'Article ID'),
            'base_url' => \Yii::t('common', 'Base Url'),
            'path' => \Yii::t('common', 'Path'),
            'size' => \Yii::t('common', 'Size'),
            'order' => \Yii::t('common', 'Order'),
            'type' => \Yii::t('common', 'Type'),
            'name' => \Yii::t('common', 'Name'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    public function getUrl()
    {
        return $this->base_url.'/'.$this->path;
    }
}
