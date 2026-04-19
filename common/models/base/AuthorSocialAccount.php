<?php

namespace common\models\base;

use common\base\BaseActiveRecord;
use common\models\Author;
use common\models\Office;
use common\models\query\AuthorSocialAccountQuery;
use common\models\SocialPlatform;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "t_author_social_account".
 *
 * @property int            $id
 * @property int            $office_id
 * @property int            $author_id
 * @property int            $platform_id
 * @property string         $username
 * @property string         $profile_url
 * @property int            $is_primary
 * @property int            $is_visible
 * @property int            $sequence
 * @property string         $description
 * @property string         $created_at
 * @property string         $updated_at
 * @property int            $created_by
 * @property int            $updated_by
 * @property int            $is_deleted
 * @property string         $deleted_at
 * @property int            $deleted_by
 * @property int            $verlock
 * @property string         $uuid
 * @property Author         $author
 * @property Office         $office
 * @property SocialPlatform $platform
 */
class AuthorSocialAccount extends BaseActiveRecord
{
    use RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct()
    {
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster.
     *
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'author',
            'office',
            'platform',
        ];
    }

    public function rules(): array
    {
        return [
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
        ];
    }

    public static function tableName(): string
    {
        return 't_author_social_account';
    }

    /**
     * @return string
     *                overwrite function optimisticLock
     *                return string name of field are used to stored optimistic lock
     */
    public function optimisticLock(): string
    {
        return 'verlock';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'office_id' => \Yii::t('common', 'Office ID'),
            'author_id' => \Yii::t('common', 'Author ID'),
            'platform_id' => \Yii::t('common', 'Platform ID'),
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

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getOffice(): ActiveQuery
    {
        return $this->hasOne(Office::class, ['id' => 'office_id']);
    }

    public function getPlatform(): ActiveQuery
    {
        return $this->hasOne(SocialPlatform::class, ['id' => 'platform_id']);
    }

    /**
     * @return array mixed
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d H:i:s'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::class,
                'column' => 'uuid',
            ],
        ];
    }

    /**
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @return AuthorSocialAccountQuery the active query used by this AR class
     */
    public static function find(): AuthorSocialAccountQuery
    {
        $query = new AuthorSocialAccountQuery(get_called_class());

        return $query->where(['t_author_social_account.deleted_by' => 0]);
    }
}
