<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportBilling extends Model
{

    public $date_first;
    public $date_last;
    public $option_date;
    
    public $billing_type;
    public $payment_status;

    public $option_detail;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date'], 'required'],
            [['billing_type','payment_status','option_detail'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'date_first'        => 'Awal',
            'date_last'         => 'Akhir',
            'option_date'       => 'Tgl',
            
            'billing_type'      => 'Type',
            'payment_status'    => 'Status',
            'option_detail'     => 'Bulan Lainnya'
        ];
    }
}

