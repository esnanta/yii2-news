<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportNote extends Model
{
    public $date_first;
    public $date_last;
    public $option_type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['option_type', 'date_first', 'date_last'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'option_type' => 'Jenis',
            'date_first' => 'Date Issued First',
            'date_last' => 'Date Issued Last',
        ];
    }
}
