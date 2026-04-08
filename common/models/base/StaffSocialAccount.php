<?php

namespace common\models\base;

use Yii;
use common\base\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;
use mootensai\relation\RelationTrait;
use common\models\query\StaffSocialAccountQuery;
use common\models\Office;
use common\models\SocialPlatform;
use common\models\Staff;

/**
 * This is the base model class for table "t_staff_social_account".
 *
 * @property integer $id
 * @property integer $office_id
 * @property integer $staff_id
 * @property integer $platform_id
 * @property string $username
 * @property string $profile_url
 * @property integer $is_primary
 * @property integer $is_visible
 * @property integer $sequence
 * @property string $description
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
 * @property Office $office
 * @property SocialPlatform $platform
 * @property Staff $staff
 */
class StaffSocialAccount extends BaseActiveRecord
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
            'office',
            'platform',
            'staff'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['office_id', 'staff_id', 'platform_id', 'is_primary', 'is_visible', 'sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['username'], 'string', 'max' => 100],
            [['profile_url'], 'string', 'max' => 500],
            [['uuid'], 'string', 'max' => 36],
            [['staff_id', 'platform_id'], 'unique', 'targetAttribute' => ['staff_id', 'platform_id'], 'message' => 'The combination of Staff ID and Platform ID has already been taken.'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 't_staff_social_account';
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
            'office_id' => Yii::t('common', 'Office ID'),
            'staff_id' => Yii::t('common', 'Staff ID'),
            'platform_id' => Yii::t('common', 'Platform ID'),
            'username' => Yii::t('common', 'Username'),
            'profile_url' => Yii::t('common', 'Profile Url'),
            'is_primary' => Yii::t('common', 'Is Primary'),
            'is_visible' => Yii::t('common', 'Is Visible'),
            'sequence' => Yii::t('common', 'Sequence'),
            'description' => Yii::t('common', 'Description'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
            'verlock' => Yii::t('common', 'Verlock'),
            'uuid' => Yii::t('common', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getOffice(): ActiveQuery
    {
        return $this->hasOne(Office::class, ['id' => 'office_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getPlatform(): ActiveQuery
    {
        return $this->hasOne(SocialPlatform::class, ['id' => 'platform_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getStaff(): ActiveQuery
    {
        return $this->hasOne(Staff::class, ['id' => 'staff_id']);
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
     * @return StaffSocialAccountQuery the active query used by this AR class.
     */
    public static function find(): StaffSocialAccountQuery    {
        $query = new StaffSocialAccountQuery(get_called_class());
        return $query->where(['t_staff_social_account.deleted_by' => 0]);
    }
}
