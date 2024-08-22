<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use common\models\base\Event as BaseEvent;
use common\helper\DateUseCase as Helper;

use DOMDocument;
use DOMXPath;

/**
 * This is the model class for table "tx_event".
 */
class Event extends BaseEvent
{
    
    public static $path='/images';    

    const IS_ACTIVE_DISABLED                = 1;
    const IS_ACTIVE_ENABLED                 = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        
        return [
            [['date_start', 'date_end', 'view_counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['location', 'content', 'description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['is_active'], 'string', 'max' => 4],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']       
        ];  
        
    }
    
    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->view_counter = 0;       
        } 
        
        if($this->is_active==self::IS_ACTIVE_ENABLED){
            //UPDATE OTHER TO DISABLED IF ACTIVE
            Event::updateAll(['is_active' => self::IS_ACTIVE_DISABLED], 'is_active ='.self::IS_ACTIVE_ENABLED);
        }
        
        $this->date_start = DateUseCase::setDateToEarlyAM($this->date_start);
        $this->date_end = DateUseCase::setDateToLatePM($this->date_end);
        
        return parent::beforeSave($insert);
    }
    
    public static function getArrayIsActive(): array
    {
        return [
            //MASTER
            self::IS_ACTIVE_DISABLED => 'No',
            self::IS_ACTIVE_ENABLED  => 'Yes',
        ];
    }  
 
    public static function getOneIsActive($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayIsActive();
            $returnValue = 'NULL';

            switch ($_module) {
                case ($_module == self::IS_ACTIVE_DISABLED):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::IS_ACTIVE_ENABLED):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
            }

            return $returnValue;

        }
        else
            return;
    }
    
    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['event/view', 'id' => $this->id, 'title' => $this->title]);
    }    

    
    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file_name = self::$path.'/default-images-01.jpg';// LOCATION : BACKEND
        return Yii::$app->urlManager->baseUrl . $file_name;        
    }     

}
