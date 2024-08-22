<?php
namespace common\models\app;

use yii\base\Model;

/**
 * Login form
 */
class ReportApplicant extends Model
{
    public $data_first;
    public $data_last;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['option', 'data_first', 'data_last'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'data_first' => 'Data First',
            'data_last' => 'Data Last',
        ];
    }
}
