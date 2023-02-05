<?php

namespace backend\models;

use Yii;
use \backend\models\base\ImportAttribute as BaseImportAttribute;

/**
 * This is the model class for table "tx_import_attribute".
 */
class ImportAttribute extends BaseImportAttribute
{
    const DATA_CONVERSION_NA = 1;
    const DATA_CONVERSION_STRING = 2;
    const DATA_CONVERSION_DATETIME_TO_STRING = 3;    
    const DATA_CONVERSION_LOOKUP = 4;
    const DATA_CONVERSION_FORMAT_NUMBER = 5;
    const DATA_CONVERSION_INVOICE = 6;
    const DATA_CONVERSION_NEW_SERIAL = 7;
    const DATA_CONVERSION_BILLING_CYCLE = 8;
    const DATA_CONVERSION_VALIDITY = 9;
    const DATA_CONVERSION_SERVICE_TYPE = 10;
    const DATA_CONVERSION_SERVICE_TO_DEVICE = 11;
    const DATA_CONVERSION_MONTH_PERIOD = 12;
    const DATA_CONVERSION_PHONE_NUMBER = 13;
    const DATA_CONVERSION_BLOG_CONTENT = 14;
    const DATA_CONVERSION_CREATE_UPDATE = 15;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['import_data_id', 'column_index', 'conversion', 'create_time', 'update_time', 'create_by', 'update_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
//    public static function get
    
    /**
     * @inheritdoc
     */
    public static function getArrayConversion()
    {
        return [
            self::DATA_CONVERSION_NA                    => 'NA',
            self::DATA_CONVERSION_STRING                => 'STRING',
            self::DATA_CONVERSION_DATETIME_TO_STRING    => 'DATETIME TO STRING',
            self::DATA_CONVERSION_LOOKUP                => 'LOOKUP',
            self::DATA_CONVERSION_FORMAT_NUMBER         => 'FORMAT NUMBER',
            self::DATA_CONVERSION_INVOICE               => 'INVOICE',
            self::DATA_CONVERSION_NEW_SERIAL            => 'NEW SERIAL',
            self::DATA_CONVERSION_BILLING_CYCLE         => 'BILLING CYCLE',
            self::DATA_CONVERSION_VALIDITY              => 'VALIDITY',
            self::DATA_CONVERSION_SERVICE_TYPE          => 'SERVICE TYPE',
            self::DATA_CONVERSION_SERVICE_TO_DEVICE     => 'SERVICE TO DEVICE',
            self::DATA_CONVERSION_MONTH_PERIOD          => 'MONTH PERIOD',
            self::DATA_CONVERSION_PHONE_NUMBER          => 'PHONE NUMBER',
            self::DATA_CONVERSION_BLOG_CONTENT          => 'BLOG CONTENT',
            self::DATA_CONVERSION_CREATE_UPDATE         => 'CREATE UPDATE',
        ];
    }      
    
    public static function getOneConversion($_data = null)
    {
        if($_data)
        {
            $arrayModule = self::getArrayConversion();
            return $arrayModule[$_data];
        }
        else
            return;
    }      
	
}
