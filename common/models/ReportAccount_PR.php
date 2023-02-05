<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportAccount_PR extends Model
{

    public $date_first;
    public $date_last;
    public $option_date;
    
    public $staff_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date'], 'required'],
            [['staff_id'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'date_first'    => 'Awal',
            'date_last'     => 'Akhir',
            'option_date'   => 'Tgl',
            
            'staff_id'      => 'Staff',
        ];
    }
}