<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_import_attribute".
 *
 * @property integer $id
 * @property integer $import_data_id
 * @property string $title
 * @property integer $column_index
 * @property integer $conversion
 * @property string $description
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $create_by
 * @property integer $update_by
 * @property string $verlock
 *
 * @property \backend\models\ImportData $importData
 */
class ImportAttribute extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'importData'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_data_id', 'column_index', 'conversion', 'create_time', 'update_time', 'create_by', 'update_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_import_attribute';
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
            'import_data_id' => 'Import Data ID',
            'title' => 'Title',
            'column_index' => 'Column Index',
            'conversion' => 'Conversion',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportData()
    {
        return $this->hasOne(\backend\models\ImportData::className(), ['id' => 'import_data_id']);
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
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'create_by',
                'updatedByAttribute' => 'update_by',
            ],
        ];
    }
}
