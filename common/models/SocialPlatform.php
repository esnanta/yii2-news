<?php

namespace common\models;

use common\models\base\SocialPlatform as BaseSocialPlatform;
use common\models\query\SocialPlatformQuery;

/**
 * This is the model class for table "t_social_platform".
 */
class SocialPlatform extends BaseSocialPlatform
{
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['code', 'name'], 'required'],
                [['sequence', 'created_by', 'updated_by', 'is_deleted',
                    'deleted_by', 'verlock'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['code'], 'string', 'max' => 50],
                [['name'], 'string', 'max' => 100],
                [['base_url'], 'string', 'max' => 255],
                [['uuid'], 'string', 'max' => 36],
                [['code'], 'unique'],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    /**
     * @return SocialPlatformQuery the active query used by this AR class
     */
    public static function find(): SocialPlatformQuery
    {
        $query = new SocialPlatformQuery(get_called_class());

        return $query->where(['t_social_platform.is_deleted' => 0]);
    }
}
