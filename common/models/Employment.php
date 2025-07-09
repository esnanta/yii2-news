<?php

namespace common\models;

use common\models\base\Employment as BaseEmployment;

/**
 * This is the model class for table "tx_employment".
 */
class Employment extends BaseEmployment
{
    public function rules(): array
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['office_id', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title'], 'string', 'max' => 100],
                [['sequence'], 'string', 'max' => 4],
                [['uuid'], 'string', 'max' => 36],
                [['title'], 'unique'],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'office_id' => \Yii::t('app', 'Office'),
            'title' => \Yii::t('app', 'Title'),
            'description' => \Yii::t('app', 'Description'),
            'sequence' => \Yii::t('app', 'Sequence'),
            'is_deleted' => \Yii::t('app', 'Is Deleted'),
            'verlock' => \Yii::t('app', 'Verlock'),
            'uuid' => \Yii::t('app', 'Uuid'),
        ];
    }
}
