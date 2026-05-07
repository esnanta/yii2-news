<?php

namespace common\models;

use common\service\LayoutService;
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $keysToInvalidate = [(string) $this->key];
        if (array_key_exists('key', $changedAttributes) && null !== $changedAttributes['key']) {
            $keysToInvalidate[] = (string) $changedAttributes['key'];
        }

        foreach (array_unique($keysToInvalidate) as $key) {
            LayoutService::invalidateByKeyStorageKey($key);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        LayoutService::invalidateByKeyStorageKey((string) $this->key);
    }
}
