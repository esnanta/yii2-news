<?php

namespace common\models;

use Yii;
use \common\models\base\AuthorSocialAccount as BaseAuthorSocialAccount;

/**
 * This is the model class for table "t_author_social_account".
 */
class AuthorSocialAccount extends BaseAuthorSocialAccount
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['office_id', 'author_id', 'platform_id', 'is_primary', 'is_visible', 'sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['username'], 'string', 'max' => 100],
            [['profile_url'], 'string', 'max' => 500],
            [['uuid'], 'string', 'max' => 36],
            [['author_id', 'platform_id'], 'unique', 'targetAttribute' => ['author_id', 'platform_id'], 'message' => 'The combination of Author ID and Platform ID has already been taken.'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
