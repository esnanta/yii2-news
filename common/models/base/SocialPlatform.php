<?php

namespace common\models\base;

use Yii;
use common\base\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;
use mootensai\relation\RelationTrait;
use common\models\query\SocialPlatformQuery;
use common\models\AuthorSocialAccount;
use common\models\OfficeSocialAccount;
use common\models\StaffSocialAccount;

/**
 * This is the base model class for table "t_social_platform".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $base_url
 * @property integer $is_active
 * @property integer $sequence
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 * @property string $uuid
 *
 * @property AuthorSocialAccount[] $authorSocialAccounts
 * @property OfficeSocialAccount[] $officeSocialAccounts
 * @property StaffSocialAccount[] $staffSocialAccounts
 */
class SocialPlatform extends BaseActiveRecord
{
    use RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
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
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'authorSocialAccounts',
            'officeSocialAccounts',
            'staffSocialAccounts'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['code', 'name'], 'required'],
            [['is_active', 'sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['base_url'], 'string', 'max' => 255],
            [['uuid'], 'string', 'max' => 36],
            [['code'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 't_social_platform';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock(): string {
        return 'verlock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'code' => Yii::t('common', 'Code'),
            'name' => Yii::t('common', 'Name'),
            'base_url' => Yii::t('common', 'Base Url'),
            'is_active' => Yii::t('common', 'Is Active'),
            'sequence' => Yii::t('common', 'Sequence'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
            'verlock' => Yii::t('common', 'Verlock'),
            'uuid' => Yii::t('common', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getAuthorSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(AuthorSocialAccount::class, ['platform_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getOfficeSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(OfficeSocialAccount::class, ['platform_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getStaffSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(StaffSocialAccount::class, ['platform_id' => 'id']);
    }
    
    /**
     * @inheritdoc
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
     * @inheritdoc
     * @return SocialPlatformQuery the active query used by this AR class.
     */
    public static function find(): SocialPlatformQuery    {
        $query = new SocialPlatformQuery(get_called_class());
        return $query->where(['t_social_platform.deleted_by' => 0]);
    }
}
