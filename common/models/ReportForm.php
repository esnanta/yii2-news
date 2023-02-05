<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportForm extends Model
{
    public $first;
    public $last;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first', 'last'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'first' => 'First',
            'last' => 'Last',
        ];
    }
}
