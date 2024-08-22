<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use common\models\base\Counter as BaseCounter;
use common\models\Lookup as Lookup;

/**
 * This is the model class for table "tx_counter".
 */
class Counter extends BaseCounter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id'], 'required'],
            [['counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['id'], 'string', 'max' => 8],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
    public static function getSerialNumber($_code) {
        $counter = 0;
        $period = date("y");

        $codeLookup = Lookup::find()->where(['token' => $_code])->asArray()->one();
        $formattedCode = $codeLookup['token'] . $period;

        $model = Counter::find()->where(['id' => $formattedCode])->one();
        if ($model == null) {
            $newCounter = new Counter();
            $newCounter->id = $formattedCode;
            $newCounter->counter = 1;
            $newCounter->save();

            $counter = 1;
        } else {
            $counter = $model->counter + 1;
            $model->counter = $counter;
            $model->save();
        }

        //FORMAT DATA COUNTER

        return $formattedCode . self::formatCounter($counter);
    }
    
    public static function getCustomerNumber($_code){
        $counter=0;
        $code   = $_code;
        $model  = Counter::find()->where(['id' => $code])->one();

        if($model==null){
            $newCounter = new Counter();
            $newCounter->id = $code;
            $newCounter->counter = 1;
            $newCounter->save();

            $counter=1;
        }
        else{
            $counter = $model->counter+1;
            $model->counter=$counter;
            $model->save();
        }

        //FORMAT DATA COUNTER
        return self::formatCounter($counter);
    }      
    
    public static function getNextNumber($_code){
        $counter=0;
        $model = Counter::find()->where(['id' => $_code])->one();
        if($model==null){
            $counter=1;
        }
        else{
            $counter = $model->counter+1;
        }

        //FORMAT DATA COUNTER
        return self::formatCounter($counter);      
    }        
    
    public static function convert($_counter){
        return self::formatCounter($_counter);  
    }
    
    private static function formatCounter($_counter) {
        $result = '';
        $counter = (int) $_counter;
        if ((int) $counter < 10) {
            $result = '0000';
        } else if ((int) $counter >= 10 && (int) $counter < 100) {
            $result = '000';
        } else if ((int) $counter >= 100 && (int) $counter < 1000) {
            $result = '00';
        } else if ((int) $counter >= 1000 && (int) $counter < 10000) {
            $result = '0';
        } else {
            $result = null;
        }

        $result = $result . $counter;
        return $result;
    }

}
