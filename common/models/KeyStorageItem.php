<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "key_storage_item".
 *
 * @property int $key
 * @property int $value
 */
class KeyStorageItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%key_storage_item}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['key'], 'string', 'max' => 128],
            [['value', 'comment'], 'safe'],
            [['key'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'key' => \Yii::t('common', 'Key'),
            'value' => \Yii::t('common', 'Value'),
            'comment' => \Yii::t('common', 'Comment'),
        ];
    }
}
