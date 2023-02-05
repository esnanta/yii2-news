<?php

namespace backend\models\base;

use Yii;

/**
 * This is the model class for table "tx_tag".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_name'], 'required'],
            [['frequency'], 'integer'],
            [['tag_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'frequency' => 'Frequency',
        ];
    }
}
