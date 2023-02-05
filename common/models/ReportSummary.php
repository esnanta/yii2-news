<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportSummary extends Model
{
    
    const OPTION_TYPE_DISPLAY               = 1;
    const OPTION_TYPE_EXPORT                = 2;
    
    const OPTION_DATE_ISSUED                = 'date_issued';
 
    
    public $date_first;
    public $date_last;
    public $option_date;
    public $option_type;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date','option_type'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'date_first'    => 'Awal',
            'date_last'     => 'Akhir',
            'option_date'   => 'Tgl',
            'option_type'   => 'Jenis',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getArrayOptionType()
    {
        return [
            //MASTER
            self::OPTION_TYPE_DISPLAY               => 'Display',
            self::OPTION_TYPE_EXPORT                => 'Export',            
        ];
    }    
    
    public static function getArrayOptionDate()
    {
        return [
            //MASTER
            self::OPTION_DATE_ISSUED               => 'Issued',           
        ];
    }       
    
    public static function getOneOptionType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayOptionType();
            return $arrayModule[$_module];
        }
        else
            return;
    }    
    
    public static function getOneOptionDate($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayOptionDate();
            return $arrayModule[$_module];
        }
        else
            return;
    }     
    
}
