<?php

namespace common\models\base;

use Yii;
use common\base\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;
use mootensai\relation\RelationTrait;
use common\models\query\StaffQuery;
use common\models\Employment;
use common\models\Office;
use common\models\StaffSocialAccount;
use common\models\User;

/**
 * This is the base model class for table "t_staff".
 *
 * @property integer $id
 * @property integer $office_id
 * @property integer $user_id
 * @property integer $employment_id
 * @property string $title
 * @property string $initial
 * @property string $identity_number
 * @property string $phone_number
 * @property integer $gender_status
 * @property integer $active_status
 * @property string $address
 * @property string $base_url
 * @property string $path
 * @property string $name
 * @property string $type
 * @property integer $size
 * @property string $email
 * @property string $google_plus
 * @property string $instagram
 * @property string $facebook
 * @property string $twitter
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
 * @property Employment $employment
 * @property Office $office
 * @property User $user
 * @property StaffSocialAccount[] $staffSocialAccounts
 */
class Staff extends BaseActiveRecord
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
            'employment',
            'office',
            'user',
            'staffSocialAccounts'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['office_id', 'user_id', 'employment_id', 'gender_status', 'active_status', 'size', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['initial'], 'required'],
            [['address', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title', 'identity_number', 'email', 'google_plus', 'instagram', 'facebook', 'twitter'], 'string', 'max' => 100],
            [['initial'], 'string', 'max' => 10],
            [['phone_number'], 'string', 'max' => 50],
            [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 't_staff';
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
            'user_id' => Yii::t('common', 'User ID'),
            'employment_id' => Yii::t('common', 'Employment ID'),
            'title' => Yii::t('common', 'Title'),
            'initial' => Yii::t('common', 'Initial'),
            'identity_number' => Yii::t('common', 'Identity Number'),
            'phone_number' => Yii::t('common', 'Phone Number'),
            'gender_status' => Yii::t('common', 'Gender Status'),
            'active_status' => Yii::t('common', 'Active Status'),
            'address' => Yii::t('common', 'Address'),
            'base_url' => Yii::t('common', 'Base Url'),
            'path' => Yii::t('common', 'Path'),
            'name' => Yii::t('common', 'Name'),
            'type' => Yii::t('common', 'Type'),
            'size' => Yii::t('common', 'Size'),
            'email' => Yii::t('common', 'Email'),
            'google_plus' => Yii::t('common', 'Google Plus'),
            'instagram' => Yii::t('common', 'Instagram'),
            'facebook' => Yii::t('common', 'Facebook'),
            'twitter' => Yii::t('common', 'Twitter'),
            'description' => Yii::t('common', 'Description'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
            'verlock' => Yii::t('common', 'Verlock'),
            'uuid' => Yii::t('common', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getEmployment(): ActiveQuery
    {
        return $this->hasOne(Employment::class, ['id' => 'employment_id']);
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
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getStaffSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(StaffSocialAccount::class, ['staff_id' => 'id']);
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
     * @return StaffQuery the active query used by this AR class.
     */
    public static function find(): StaffQuery    {
        $query = new StaffQuery(get_called_class());
        return $query->where(['t_staff.deleted_by' => 0]);
    }
}
