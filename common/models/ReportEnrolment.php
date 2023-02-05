<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportEnrolment extends Model
{
    public $date_first;
    public $date_last;
    public $option_date;
    public $enrolment_type;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date','enrolment_type'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'date_first'    => 'Awal',
            'date_last'     => 'Akhir',
            'option_date'   => 'Tgl',
            
            'enrolment_type'      => 'Jenis',
        ];
    }
}
