<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_content".
 *
 * @property integer $id
 * @property integer $theme_id
 * @property string $title
 * @property string $token
 * @property string $icon
 * @property string $label
 * @property string $file_name
 * @property string $content
 * @property string $description
 * @property string $verlock
 *
 * @property \backend\models\Theme $theme
 */
class Content extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'theme'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['theme_id', 'verlock'], 'integer'],
            [['content', 'description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 5],
            [['icon', 'label'], 'string', 'max' => 50],
            [['file_name'], 'string', 'max' => 300],
            [['token'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_content';
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
            'theme_id' => 'Theme ID',
            'title' => 'Title',
            'token' => 'Token',
            'icon' => 'Icon',
            'label' => 'Label',
            'file_name' => 'File Name',
            'content' => 'Content',
            'description' => 'Description',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(\backend\models\Theme::className(), ['id' => 'theme_id']);
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
