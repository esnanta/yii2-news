<?php

namespace common\models;

use common\models\base\OfficeSocialAccount as BaseOfficeSocialAccount;
use common\models\query\OfficeSocialAccountQuery;

/**
 * This is the model class for table "t_office_social_account".
 */
class OfficeSocialAccount extends BaseOfficeSocialAccount
{

    public const FLAG_NO = 2;
    public const FLAG_YES = 1;

    /**
     * @return array options for is_primary dropdown
     */
    public static function primaryOptions(): array
    {
        return [
            self::FLAG_NO => \Yii::t('common', 'No'),
            self::FLAG_YES => \Yii::t('common', 'Yes'),
        ];
    }

    /**
     * @return array options for is_visible dropdown
     */
    public static function visibleOptions(): array
    {
        return [
            self::FLAG_NO => \Yii::t('common', 'No'),
            self::FLAG_YES => \Yii::t('common', 'Yes'),
        ];
    }

    public function rules(): array
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['office_id', 'platform_id', 'is_primary', 'is_visible',
                    'sequence', 'created_by', 'updated_by',
                    'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['username'], 'string', 'max' => 100],
                [['profile_url'], 'string', 'max' => 500],
                [['uuid'], 'string', 'max' => 36],
                [['office_id', 'platform_id'], 'unique',
                    'targetAttribute' => ['office_id', 'platform_id'],
                    'message' => 'The combination of Office ID and Platform ID has already been taken.'],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    /**
     * @return OfficeSocialAccountQuery the active query used by this AR class
     */
    public static function find(): OfficeSocialAccountQuery
    {
        $query = new OfficeSocialAccountQuery(get_called_class());

        return $query->where(['t_office_social_account.is_deleted' => 0]);
    }
}
