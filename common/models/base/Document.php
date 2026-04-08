<?php

namespace common\models\base;

use common\base\BaseActiveRecord;
use common\models\DocumentCategory;
use common\models\Office;
use common\models\query\DocumentQuery;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "t_document".
 *
 * @property int              $id
 * @property int              $office_id
 * @property int              $is_visible
 * @property int              $category_id
 * @property string           $title
 * @property string           $date_issued
 * @property string           $base_url
 * @property string           $path
 * @property string           $name
 * @property string           $type
 * @property int              $size
 * @property int              $view_count
 * @property int              $download_count
 * @property string           $description
 * @property string           $created_at
 * @property string           $updated_at
 * @property int              $created_by
 * @property int              $updated_by
 * @property int              $is_deleted
 * @property string           $deleted_at
 * @property int              $deleted_by
 * @property int              $verlock
 * @property string           $uuid
 * @property DocumentCategory $category
 * @property Office           $office
 */
class Document extends BaseActiveRecord
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
            'category',
            'office',
        ];
    }

    public function rules(): array
    {
        return [
            [['office_id', 'is_visible', 'category_id', 'size', 'view_count', 'download_count',
                'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public static function tableName(): string
    {
        return 't_document';
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
            'is_visible' => \Yii::t('common', 'Is Visible'),
            'category_id' => \Yii::t('common', 'Category ID'),
            'title' => \Yii::t('common', 'Title'),
            'date_issued' => \Yii::t('common', 'Date Issued'),
            'base_url' => \Yii::t('common', 'Base Url'),
            'path' => \Yii::t('common', 'Path'),
            'name' => \Yii::t('common', 'Name'),
            'type' => \Yii::t('common', 'Type'),
            'size' => \Yii::t('common', 'Size'),
            'view_count' => \Yii::t('common', 'View Count'),
            'download_count' => \Yii::t('common', 'Download Count'),
            'description' => \Yii::t('common', 'Description'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(DocumentCategory::class, ['id' => 'category_id']);
    }

    public function getOffice(): ActiveQuery
    {
        return $this->hasOne(Office::class, ['id' => 'office_id']);
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
     * @return DocumentQuery the active query used by this AR class
     */
    public static function find(): DocumentQuery
    {
        $query = new DocumentQuery(get_called_class());

        return $query->where(['t_document.deleted_by' => 0]);
    }
}
