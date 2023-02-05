<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportCustomer extends Model
{
    public $title;
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
            'title' => 'Title',
            'data_first' => 'Data First',
            'data_last' => 'Data Last',
        ];
    }
}
