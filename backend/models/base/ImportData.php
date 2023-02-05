<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_import_data".
 *
 * @property integer $id
 * @property integer $modul_type
 * @property string $title
 * @property integer $row_start
 * @property integer $row_end
 * @property string $file_name
 * @property string $description
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $create_by
 * @property integer $update_by
 * @property string $verlock
 *
 * @property \backend\models\ImportAttribute[] $importAttributes
 */
class ImportData extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'importAttributes'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modul_type', 'row_start', 'row_end', 'create_time', 'update_time', 'create_by', 'update_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title', 'file_name'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_import_data';
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
            'modul_type' => 'Modul Type',
            'title' => 'Title',
            'row_start' => 'Row Start',
            'row_end' => 'Row End',
            'file_name' => 'File Name',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'verlock' => 'Varlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportAttributes()
    {
        return $this->hasMany(\backend\models\ImportAttribute::className(), ['import_data_id' => 'id']);
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
