<?php

namespace common\models;

use common\models\base\Office as BaseOffice;
use common\models\query\OfficeQuery;

/**
 * This is the model class for table "t_office".
 */
class Office extends BaseOffice
{
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['unique_id'], 'string', 'max' => 15],
                [['title', 'phone_number', 'fax_number', 'email', 'web', 'address',
                    'latitude', 'longitude'], 'string', 'max' => 100],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    /**
     * @return OfficeQuery the active query used by this AR class
     */
    public static function find(): OfficeQuery
    {
        $query = new OfficeQuery(get_called_class());

        return $query->where(['t_office.is_deleted' => 0]);
    }
}
