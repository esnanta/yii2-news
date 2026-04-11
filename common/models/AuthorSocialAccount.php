<?php

namespace common\models;

use common\models\base\AuthorSocialAccount as BaseAuthorSocialAccount;
use common\models\query\AuthorSocialAccountQuery;

/**
 * This is the model class for table "t_author_social_account".
 */
class AuthorSocialAccount extends BaseAuthorSocialAccount
{
    /**
     * Returns consistent checkbox post values for integer-flag attributes.
     */
    public function getCheckboxInputOptions(string $attribute): array
    {
        if (in_array($attribute, ['is_primary', 'is_visible'], true)) {
            return [
                'value' => 1,
                'uncheck' => 0,
            ];
        }

        return [];
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['office_id', 'author_id', 'platform_id',
                    'is_primary', 'is_visible', 'sequence',
                    'created_by', 'updated_by', 'is_deleted',
                    'deleted_by', 'verlock'], 'integer'],
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['username'], 'string', 'max' => 100],
                [['profile_url'], 'string', 'max' => 500],
                [['uuid'], 'string', 'max' => 36],
                [['author_id', 'platform_id'], 'unique',
                    'targetAttribute' => ['author_id', 'platform_id'],
                    'message' => 'The combination of Author ID and Platform ID has already been taken.'],
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
            'author_id' => \Yii::t('common', 'Author'),
            'platform_id' => \Yii::t('common', 'Platform'),
            'username' => \Yii::t('common', 'Username'),
            'profile_url' => \Yii::t('common', 'Profile Url'),
            'is_primary' => \Yii::t('common', 'Is Primary'),
            'is_visible' => \Yii::t('common', 'Is Visible'),
            'sequence' => \Yii::t('common', 'Sequence'),
            'description' => \Yii::t('common', 'Description'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }


    /**
     * @return AuthorSocialAccountQuery the active query used by this AR class
     */
    public static function find(): AuthorSocialAccountQuery
    {
        $query = new AuthorSocialAccountQuery(get_called_class());

        return $query->where(['t_author_social_account.is_deleted' => 0]);
    }
}
