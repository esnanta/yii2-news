<?php

namespace common\models\base;

use common\base\BaseActiveRecord;
use common\models\Employment;
use common\models\Office;
use common\models\query\StaffQuery;
use common\models\StaffSocialAccount;
use common\models\User;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "t_staff".
 *
 * @property int                  $id
 * @property int                  $office_id
 * @property int                  $user_id
 * @property int                  $employment_id
 * @property string               $title
 * @property string               $initial
 * @property string               $identity_number
 * @property string               $phone_number
 * @property int                  $gender_status
 * @property int                  $active_status
 * @property string               $address
 * @property string               $photo_base_url
 * @property string               $photo_path
 * @property string               $photo_name
 * @property string               $photo_type
 * @property int                  $photo_size
 * @property string               $email
 * @property string               $google_plus
 * @property string               $instagram
 * @property string               $facebook
 * @property string               $twitter
 * @property string               $description
 * @property string               $created_at
 * @property string               $updated_at
 * @property int                  $created_by
 * @property int                  $updated_by
 * @property int                  $is_deleted
 * @property string               $deleted_at
 * @property int                  $deleted_by
 * @property int                  $verlock
 * @property string               $uuid
 * @property Employment           $employment
 * @property Office               $office
 * @property User                 $user
 * @property StaffSocialAccount[] $staffSocialAccounts
 */
class Staff extends BaseActiveRecord
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
            'employment',
            'office',
            'user',
            'staffSocialAccounts',
        ];
    }

    public function rules(): array
    {
        return [
            [['office_id', 'user_id', 'employment_id', 'gender_status', 'active_status', 'photo_size', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['initial'], 'required'],
            [['address', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title', 'identity_number', 'email', 'google_plus', 'instagram', 'facebook', 'twitter'], 'string', 'max' => 100],
            [['initial'], 'string', 'max' => 10],
            [['phone_number'], 'string', 'max' => 50],
            [['photo_base_url', 'photo_path', 'photo_name', 'photo_type'], 'string', 'max' => 255],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public static function tableName(): string
    {
        return 't_staff';
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
            'user_id' => \Yii::t('common', 'User ID'),
            'employment_id' => \Yii::t('common', 'Employment ID'),
            'title' => \Yii::t('common', 'Title'),
            'initial' => \Yii::t('common', 'Initial'),
            'identity_number' => \Yii::t('common', 'Identity Number'),
            'phone_number' => \Yii::t('common', 'Phone Number'),
            'gender_status' => \Yii::t('common', 'Gender Status'),
            'active_status' => \Yii::t('common', 'Active Status'),
            'address' => \Yii::t('common', 'Address'),
            'photo_base_url' => \Yii::t('common', 'Photo Base Url'),
            'photo_path' => \Yii::t('common', 'Photo Path'),
            'photo_name' => \Yii::t('common', 'Photo Name'),
            'photo_type' => \Yii::t('common', 'Photo Type'),
            'photo_size' => \Yii::t('common', 'Photo Size'),
            'email' => \Yii::t('common', 'Email'),
            'google_plus' => \Yii::t('common', 'Google Plus'),
            'instagram' => \Yii::t('common', 'Instagram'),
            'facebook' => \Yii::t('common', 'Facebook'),
            'twitter' => \Yii::t('common', 'Twitter'),
            'description' => \Yii::t('common', 'Description'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    public function getEmployment(): ActiveQuery
    {
        return $this->hasOne(Employment::class, ['id' => 'employment_id']);
    }

    public function getOffice(): ActiveQuery
    {
        return $this->hasOne(Office::class, ['id' => 'office_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getStaffSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(StaffSocialAccount::class, ['staff_id' => 'id']);
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
     * @return StaffQuery the active query used by this AR class
     */
    public static function find(): StaffQuery
    {
        $query = new StaffQuery(get_called_class());

        return $query->where(['t_staff.deleted_by' => 0]);
    }
}
