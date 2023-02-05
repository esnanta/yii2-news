<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Event as BaseEvent;
use common\helper\Helper as Helper;

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
        
        $this->date_start = Helper::setDateToEarlyAM($this->date_start);
        $this->date_end = Helper::setDateToLatePM($this->date_end);
        
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'title'                 => Yii::$app->params['Attribute_Title'],
            'date_start'            => Yii::$app->params['Attribute_DateStart'],
            'date_end'              => Yii::$app->params['Attribute_DateEnd'],
            'location'              => Yii::$app->params['Attribute_Location'],
            'content'               => Yii::$app->params['Attribute_Content'],
            'view_counter'          => Yii::$app->params['Attribute_ViewCounter'],
            'description'           => Yii::$app->params['Attribute_Description'],
            
            'is_active'             => 'Aktif',
            'is_deleted'            => 'Deleted',
            
            'created_at'            => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'            => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'            => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'            => Yii::$app->params['Attribute_UpdatedBy'],
            'verlock'               => 'Verlock',
        ];
    }
    
    public static function getArrayIsActive()
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
    
    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
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
    
    public function configureContentImage(){
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content);
        $xpath = new DOMXPath($dom);

        foreach ($xpath->query("//img") as $node) {
            $node->setAttribute("class", "img-responsive img-fluid");
        }
        
        return str_replace('%09', '', $dom->saveHtml());        
    }    
    
    public function getCover($html){
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        
        //$srcVideo   = $xpath->evaluate("string(//iframe/@src)"); 
        $srcImage   = $xpath->evaluate("string(//img/@src)"); 
        
//        if(!empty($srcVideo)){
//            $value = $srcVideo;
//        }
//        else
            
        if(!empty($srcImage)){
            $value = $srcImage;
        }
        else{
            $value = $this->getImageUrl();
        }
        
        return $value;        
    }       
    
    
    /*     * *******************************************************************
      Purpose       : function to truncate text and show read more links.
      Parameters    : @$story_desc : story description
      @$link        : story link
      @$targetFile  : target redirect file name
      @$id          : story id
      Returns       : string
     * ********************************************************************* */

    public function readMore($size=null) {
        /*
         * KEEP TAGS HTML & BODY
         * DELETE OTHER TAGS
         */
        $html = strip_tags($this->content);
        
        /*
         * CUT TEXT
         */        
        $chars = (!empty($size)) ? $size : 150;
        $tmpContent = substr($html, 0, $chars);
        $updateContent = substr($tmpContent, 0, strrpos($tmpContent, ' '));
        $newContent = $updateContent;
        return $newContent;
    }    
}
