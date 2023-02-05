<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\Page as BasePage;
use DOMDocument;
use DOMXPath;
/**
 * This is the model class for table "tx_page".
 */
class Page extends BasePage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_type_id', 'sequence', 'view_counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'verlock', 'is_deleted', 'deleted_at', 'deleted_by'], 'integer'],
            [['description', 'content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']      
        ];         
        
    }
    
    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['page/view', 'id' => $this->id, 'title' => $this->title]);
    }    
    
    public function getCover($html){
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        
        $srcDefault = $this->getImageUrl();
        $srcVideo   = $xpath->evaluate("string(//iframe/@src)"); 
        $srcImage   = $xpath->evaluate("string(//img/@src)"); 
        
        if(!empty($srcVideo)){
            $value = $srcVideo;
        }
        elseif(!empty($srcImage)){
            $value = $srcImage;
        }
        else{
            $value = $srcDefault;
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
        $html = strip_tags($this->content,'<html>,<body>');
        
        /*
         * CUT TEXT
         */        
        $chars = (!empty($size)) ? $size : 150;
        $tmpContent = substr($html, 0, $chars);
        $updateContent = substr($tmpContent, 0, strrpos($tmpContent, ' '));
        $newContent = $updateContent;
        return $newContent;
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
}
