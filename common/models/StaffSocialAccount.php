<?php

namespace common\models;

use common\models\base\StaffSocialAccount as BaseStaffSocialAccount;
use common\models\query\StaffSocialAccountQuery;

/**
 * This is the model class for table "t_staff_social_account".
 */
class StaffSocialAccount extends BaseStaffSocialAccount
{
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['office_id', 'staff_id', 'platform_id', 'is_primary', 'is_visible',
                    'sequence', 'created_by', 'updated_by',
                    'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['username'], 'string', 'max' => 100],
                [['profile_url'], 'string', 'max' => 500],
                [['uuid'], 'string', 'max' => 36],
                [['staff_id', 'platform_id'], 'unique',
                    'targetAttribute' => ['staff_id', 'platform_id'],
                    'message' => 'The combination of Staff ID and Platform ID has already been taken.'],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    /**
     * @return StaffSocialAccountQuery the active query used by this AR class
     */
    public static function find(): StaffSocialAccountQuery
    {
        $query = new StaffSocialAccountQuery(get_called_class());

        return $query->where(['t_staff_social_account.is_deleted' => 0]);
    }
}
