<?php

namespace common\models;

use common\models\base\JobTitle as BaseEmployment;
use common\models\query\JobTitleQuery;

/**
 * This is the model class for table "t_employment".
 */
class JobTitle extends BaseEmployment
{
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['office_id', 'sequence', 'created_by', 'updated_by',
                    'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title'], 'string', 'max' => 100],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }
    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'office_id' => \Yii::t('common', 'Office'),
            'title' => \Yii::t('common', 'Title'),
            'description' => \Yii::t('common', 'Description'),
            'sequence' => \Yii::t('common', 'Sequence'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }
    /**
     * @return JobTitleQuery the active query used by this AR class
     */
    public static function find(): JobTitleQuery
    {
        $query = new JobTitleQuery(get_called_class());

        return $query->where(['t_employment.is_deleted' => 0]);
    }
}
