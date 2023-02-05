<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportService extends Model
{

    public $date_first;
    public $date_last;
    public $option_date;
    
    public $customer_id;
    public $staff_id;

    public $option_detail;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date'], 'required'],
            [['customer_id','staff_id','option_detail'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'date_first'        => 'Awal',
            'date_last'         => 'Akhir',
            'option_date'       => 'Tgl',
            
            'customer_id'       => 'Customer',
            'staff_id'          => 'Staff',
            'option_detail'     => 'With Detail',
        ];
    }
}

