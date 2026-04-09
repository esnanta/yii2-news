<?php

namespace common\models\base;

use common\base\BaseActiveRecord;
use common\models\Author;
use common\models\AuthorSocialAccount;
use common\models\Document;
use common\models\DocumentCategory;
use common\models\Employment;
use common\models\OfficeSocialAccount;
use common\models\query\OfficeQuery;
use common\models\Staff;
use common\models\StaffSocialAccount;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "t_office".
 *
 * @property int                   $id
 * @property string                $unique_id
 * @property string                $title
 * @property string                $phone_number
 * @property string                $fax_number
 * @property string                $email
 * @property string                $web
 * @property string                $address
 * @property string                $latitude
 * @property string                $longitude
 * @property string                $description
 * @property string                $created_at
 * @property string                $updated_at
 * @property int                   $created_by
 * @property int                   $updated_by
 * @property int                   $is_deleted
 * @property string                $deleted_at
 * @property int                   $deleted_by
 * @property int                   $verlock
 * @property string                $uuid
 * @property Author[]              $authors
 * @property AuthorSocialAccount[] $authorSocialAccounts
 * @property Document[]            $documents
 * @property DocumentCategory[]    $documentCategories
 * @property Employment[]          $employments
 * @property OfficeSocialAccount[] $officeSocialAccounts
 * @property Staff[]               $staff
 * @property StaffSocialAccount[]  $staffSocialAccounts
 */
class Office extends BaseActiveRecord
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
            'authors',
            'authorSocialAccounts',
            'documents',
            'documentCategories',
            'employments',
            'officeSocialAccounts',
            'staff',
            'staffSocialAccounts',
        ];
    }

    public function rules(): array
    {
        return [
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['unique_id'], 'string', 'max' => 15],
            [['title', 'phone_number', 'fax_number', 'email', 'web', 'address',
                'latitude', 'longitude'], 'string', 'max' => 100],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public static function tableName(): string
    {
        return 't_office';
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
            'unique_id' => \Yii::t('common', 'Unique ID'),
            'title' => \Yii::t('common', 'Title'),
            'phone_number' => \Yii::t('common', 'Phone Number'),
            'fax_number' => \Yii::t('common', 'Fax Number'),
            'email' => \Yii::t('common', 'Email'),
            'web' => \Yii::t('common', 'Web'),
            'address' => \Yii::t('common', 'Address'),
            'latitude' => \Yii::t('common', 'Latitude'),
            'longitude' => \Yii::t('common', 'Longitude'),
            'description' => \Yii::t('common', 'Description'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['office_id' => 'id']);
    }

    public function getAuthorSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(AuthorSocialAccount::class, ['office_id' => 'id']);
    }

    public function getDocuments(): ActiveQuery
    {
        return $this->hasMany(Document::class, ['office_id' => 'id']);
    }

    public function getDocumentCategories(): ActiveQuery
    {
        return $this->hasMany(DocumentCategory::class, ['office_id' => 'id']);
    }

    public function getEmployments(): ActiveQuery
    {
        return $this->hasMany(Employment::class, ['office_id' => 'id']);
    }

    public function getOfficeSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(OfficeSocialAccount::class, ['office_id' => 'id']);
    }

    public function getStaff(): ActiveQuery
    {
        return $this->hasMany(Staff::class, ['office_id' => 'id']);
    }

    public function getStaffSocialAccounts(): ActiveQuery
    {
        return $this->hasMany(StaffSocialAccount::class, ['office_id' => 'id']);
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
     * @return OfficeQuery the active query used by this AR class
     */
    public static function find(): OfficeQuery
    {
        $query = new OfficeQuery(get_called_class());

        return $query->where(['t_office.deleted_by' => 0]);
    }
}
