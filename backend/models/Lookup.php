<?php

namespace backend\models;

use Yii;
use \backend\models\base\Lookup as BaseLookup;

/**
 * This is the model class for table "tx_lookup".
 */
class Lookup extends BaseLookup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['sequence', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['token'], 'string', 'max' => 5],
            [['category'], 'string', 'max' => 30],
            [['token'], 'unique'],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
   public static function getId($_token) 
   { 
        //https://www.yiiframework.com/doc/guide/2.0/en/caching-data
        //$db = Yii::$app->db;// or Category::getDb()
        $value = Lookup::getDb()->cache(function () use ($_token) {
            $model = Lookup::find()->where(['token' => $_token])->one();
            return $model->id;
        });       

       return $value; 
   }  
   
   public static function getIdByToken($_token) 
   { 
        //https://www.yiiframework.com/doc/guide/2.0/en/caching-data
        //$db = Yii::$app->db;// or Category::getDb()
        $value = Lookup::getDb()->cache(function () use ($_token) {
            $model = Lookup::find()->where(['token' => $_token])->one();
            return $model->id;
        });       

       return $value; 
   }     
   
   public static function getTitleById($_id) 
   { 
        //https://www.yiiframework.com/doc/guide/2.0/en/caching-data
        //$db = Yii::$app->db;// or Category::getDb()
        $value = Lookup::getDb()->cache(function () use ($_id) {
            $model = Lookup::find()->where(['id' => $_id])->one();
            return $model->title;
        });       

       return $value;        
   }     
   
   public function getLabel(){
       $returnValue = '<span class="label label-default">'.$this->title.'</span>';
       $value = $this->token;
       
        switch ($value) {

            case ($value == Yii::$app->params['LookupToken_YES']):
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_NO']):
                $returnValue = '<span class="label label-danger">'.$this->title.'</span>';
                break;
            
            ////////////////////////////////////////////////////////////////////

            case ($value == Yii::$app->params['LookupToken_Private']):
                $returnValue = '<span class="label label-danger">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_Public']):
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;            
            
            ////////////////////////////////////////////////////////////////////
            //APPROVAL            
            case ($value == Yii::$app->params['LookupToken_OnTime']):
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_Overdue']):
                $returnValue = '<span class="label label-danger">'.$this->title.'</span>';
                break;            
            
            ////////////////////////////////////////////////////////////////////
            //APPROVAL
            case ($value == Yii::$app->params['LookupToken_Approved']):
                $returnValue = '<span class="label label-primary">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_Rejected']):
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;               
            
            case ($value == Yii::$app->params['LookupToken_Pending']):
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;                   
            ////////////////////////////////////////////////////////////////////
            //ASSEMBLY TYPE
            case ($value == Yii::$app->params['LookupToken_AssemblyTypeNew'])://PASANG BARU
                $returnValue = '<span class="label label-primary">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_AssemblyTypeMoving'])://PASANG PINDAH
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;           
            
            ////////////////////////////////////////////////////////////////////
            //DEVICE TYPE
            case ($value == Yii::$app->params['LookupToken_DeviceMain'])://MAIN DEVICE - INDUK
                $returnValue = '<span class="label label-primary">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_DeviceParalel'])://PARALEL DEVICE - PARALEL   
                $returnValue = '<span class="label label-info">'.$this->title.'</span>';
                break;         
            
            ////////////////////////////////////////////////////////////////////
            //BILLING TYPE
            case ($value == Yii::$app->params['LookupToken_BillingTypeNew'])://BILLING TYPE NEW DEVICE ASSEMBLY 
                $returnValue = '<span class="label label-primary">'.$this->title.'</span>';
                break;
            
            case ($value == Yii::$app->params['LookupToken_BillingTypeParalel'])://BILLING TYPE PARALEL DEVICE ASSEMBLY
                $returnValue = '<span class="label label-info">'.$this->title.'</span>';
                break;            
            
            case ($value == Yii::$app->params['LookupToken_BillingTypeMoving'])://BILLING TYPE MOVE DEVICE ASSEMBLY
                $returnValue = '<span class="label label-danger">'.$this->title.'</span>';
                break;
            
            case ($value == Yii::$app->params['LookupToken_BillingTypeMonthly'])://BILLING TYPE MONTHLY INSTALLMENT     
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;              

            ////////////////////////////////////////////////////////////////////
            //DEVICE STATUS
            case ($value == Yii::$app->params['LookupToken_DeviceStatusActive'])://OUTLET STATUS ACTIVE
                $returnValue = '<span class="label label-primary">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_DeviceStatusFree'])://OUTLET STATUS FREE
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break; 
            case ($value == Yii::$app->params['LookupToken_DeviceStatusIdle'])://OUTLET STATUS NON ACTIVE
                $returnValue = '<span class="label label-warning">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_DeviceStatusDisconnect'])://OUTLET STATUS DISCONNECT    
                $returnValue = '<span class="label label-default">'.$this->title.'</span>';
                break;      
            
            ////////////////////////////////////////////////////////////////////
            //PAYMENT STATUS
            case ($value == Yii::$app->params['LookupToken_PaymentStatusCredit'])://PAYMENT CREDIT 
                $returnValue = '<span class="label label-danger">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_PaymentStatusInstallment'])://PAYMENT INSTALLMENT 
                $returnValue = '<span class="label label-warning">'.$this->title.'</span>';
                break;

            case ($value == Yii::$app->params['LookupToken_PaymentStatusPaidOff'])://PAYMENT PAID OFF   
                $returnValue = '<span class="label label-success">'.$this->title.'</span>';
                break;    
            
            ////////////////////////////////////////////////////////////////////

            default:
                return $returnValue;
        }       
       return $returnValue;
   }
}
