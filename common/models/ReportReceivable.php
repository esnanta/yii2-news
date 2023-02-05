<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportReceivable extends Model
{

    public $date_first;
    public $date_last;
    public $option_date;
    
    public $staff_id;
    public $option_detail;
            
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date','option_detail'], 'required'],
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
            'option_detail' => 'With Detail',
        ];
    }
}