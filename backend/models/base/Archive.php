<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_archive".
 *
 * @property integer $id
 * @property integer $is_visible
 * @property integer $archive_type
 * @property integer $archive_category_id
 * @property string $title
 * @property string $date_issued
 * @property string $file_name
 * @property string $archive_url
 * @property integer $size
 * @property string $mime_type
 * @property integer $view_counter
 * @property integer $download_counter
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 *
 * @property \backend\models\ArchiveCategory $archiveCategory
 */
class Archive extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

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
    public function relationNames()
    {
        return [
            'archiveCategory'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_visible', 'archive_type', 'archive_category_id', 'size', 'view_counter', 'download_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['description'], 'string'],
            [['title', 'file_name'], 'string', 'max' => 200],
            [['archive_url'], 'string', 'max' => 500],
            [['mime_type'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_archive';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'verlock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_visible' => 'Is Visible',
            'archive_type' => 'Archive Type',
            'archive_category_id' => 'Archive Category ID',
            'title' => 'Title',
            'date_issued' => 'Date Issued',
            'file_name' => 'File Name',
            'archive_url' => 'Archive Url',
            'size' => 'Size',
            'mime_type' => 'Mime Type',
            'view_counter' => 'View Counter',
            'download_counter' => 'Download Counter',
            'description' => 'Description',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchiveCategory()
    {
        return $this->hasOne(\backend\models\ArchiveCategory::className(), ['id' => 'archive_category_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
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
     * @return \backend\models\ArchiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \backend\models\ArchiveQuery(get_called_class());
        return $query->where(['tx_archive.deleted_by' => 0]);
    }
}
