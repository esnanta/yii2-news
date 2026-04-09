<?php

namespace common\models;

use common\models\base\SocialPlatform as BaseSocialPlatform;

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
                [['is_active', 'sequence', 'created_by', 'updated_by', 'is_deleted',
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
}
