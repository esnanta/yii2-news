<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\FileHelper;

use backend\models\base\Blog as BaseBlog;
use backend\models\Author;

use common\helper\Helper;

use DOMDocument;
use DOMXPath;

class Blog extends BaseBlog
{
    public static $path='/images';
    private $_oldTags;
    
    const PUBLISH_STATUS_NO     = 1;
    const PUBLISH_STATUS_YES    = 2;
    
    const PINNED_STATUS_NO      = 1;
    const PINNED_STATUS_YES     = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        
        return [
            
            [['category_id', 'title', 'content'], 'required'],
            [['category_id', 'author_id', 'publish_status', 'pinned_status', 'view_counter', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at', 'verlock'], 'integer'],
            [['content', 'description'], 'string'],
            [['tags'], 'safe'],
            [['rating'], 'number'],
            [['title'], 'string', 'max' => 150],
            [['cover', 'url'], 'string', 'max' => 300],
            [['month_period'], 'string', 'max' => 6],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']     
        ];        
        
        
    }
    
    
    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'author',
            'category',
            'user' // TAMBAHAN
        ];
    }    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id'       => Yii::$app->params['Attribute_Category'],
            'author_id'         => Yii::$app->params['Attribute_Author'],
            'title'             => 'Judul',
            'cover'             => Yii::$app->params['Attribute_Cover'],
            'url'               => 'Url',
            'content'           => Yii::$app->params['Attribute_Content'],
            'description'       => Yii::$app->params['Attribute_Description'],
            'tags'              => 'Tags',
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'publish_status'    => Yii::$app->params['Attribute_PublishStatus'],
            'pinned_status'     => Yii::$app->params['Attribute_PinnedStatus'],
            'view_counter'      => 'View',
            'rating'            => 'Rating',
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
            'created_at'        => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'        => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'        => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'        => Yii::$app->params['Attribute_UpdatedBy'],
            
            'is_deleted'        => 'Deleted',
            'deleted_at'        => Yii::$app->params['Attribute_DeletedAt'],
            'deleted_by'        => Yii::$app->params['Attribute_DeletedBy'],
            
            'verlock'           => 'Verlock',
        ];
    }
    
    public static function getArrayPublishStatus()
    {
        return [
            //MASTER
            self::PUBLISH_STATUS_NO      => 'Draft',
            self::PUBLISH_STATUS_YES     => 'Released',
        ];
    }

    public static function getOnePublishStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayPublishStatus();
            $returnValue = 'NULL';

            switch ($_module) {
                case ($_module == self::PUBLISH_STATUS_NO):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::PUBLISH_STATUS_YES):
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
    
    public static function getArrayPinnedStatus()
    {
        return [
            //MASTER
            self::PINNED_STATUS_NO      => 'Unpinned',
            self::PINNED_STATUS_YES     => 'Pinned',
        ];
    }

    public static function getOnePinnedStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayPinnedStatus();
            $returnValue = 'NULL';

            switch ($_module) {
                case ($_module == self::PINNED_STATUS_NO):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::PINNED_STATUS_YES):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\backend\models\User::className(), ['id' => 'created_by']);
    }    
    
    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->view_counter         = 0;
            $this->publish_status       = self::PUBLISH_STATUS_NO;  
            $this->pinned_status        = self::PINNED_STATUS_NO;            
        }            
        
        if(empty($this->date_issued)){
            $this->date_issued          = $this->created_at;
        }        
        
        $this->date_issued              = Helper::setDateToNoon($this->date_issued);
        $this->month_period             = Helper::getMonthPeriod($this->date_issued);
        
        return parent::beforeSave($insert);
    }

    /**
     * After save.
     *
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // add your code here
        Tag::updateFrequency($this->_oldTags, $this->tags);
    }

    /**
     * After save.
     *
     */
    public function afterDelete()
    {
        parent::afterDelete();
        // add your code here
        Tag::updateFrequencyOnDelete($this->_oldTags);
    }

    /**
     * This is invoked when a record is populated with data from a find() call.
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }


    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['blog/view', 'id' => $this->id, 'title' => $this->title]);
    }

    /**
     *
     */
    public function setPublishUrl()
    {
        $value = ($this->publish_status == self::PUBLISH_STATUS_NO) ? 
                '<span class="btn btn-primary">Set As Publish</span>' : 
                '<span class="btn btn-default">Set As Draft</span>';        
        return Html::a($value, Yii::$app->getUrlManager()->createUrl(['blog/publish','id'=>$this->id]));
    }    
    
    public function setPinUrl()
    {
        $value = ($this->pinned_status == self::PINNED_STATUS_NO) ? 
                '<span class="btn btn-success">Set As Pinned</span>' : 
                '<span class="btn btn-danger">Set As Unpinned</span>';        
        return Html::a($value, Yii::$app->getUrlManager()->createUrl(['blog/pinned','id'=>$this->id]));
    }      
    
    /**
     *
     */
    public function getTagLinks()
    {
        $links = [];
        foreach(Tag::string2array($this->tags) as $tag){
            $links[] = Html::a($tag, Yii::$app->getUrlManager()->createUrl(['blog/index', 'tag'=>$tag]));
        }
        return $links;
    }

    /**
     *
     */
    public function getTagLinksWithBadge($class)
    {
        $links = [];
        foreach(Tag::string2array($this->tags) as $tag){
            $links[] = Html::a('<span class="'.$class.'">'.$tag.'</span>', Yii::$app->getUrlManager()->createUrl(['blog/index', 'tag'=>$tag]));
        }
        return $links;
    }    

    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        $directory = Yii::getAlias('@webroot') . self::$path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);      
        }
        return $directory;
    }     
    
    public function getLabel(){
        $checkDatediff = time() - $this->created_at;
        $diffValue = floor($checkDatediff/(60*60*24));             
        
        $value = '';
        
        if($diffValue <= 6){
            $value = '<span class="float-right u-label g-bg-blue g-rounded-3 g-mr-10 g-mb-15">NEW</span>';
        }
        elseif($diffValue <= 6 && $this->view_counter >=50){
            $value = '<span class="float-right u-label g-bg-lightred g-rounded-3 g-mr-10 g-mb-15">HOT</span>';
        }        
        return $value;
    }
    
    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file_name = 'default-images-02.jpg';// LOCATION : BACKEND
        return Yii::$app->urlManager->baseUrl .self::$path.'/'. $file_name;
    }      
    
    /**
     * fetch stored image url
     * @return string
     */
    public function getDefaultAuthorImage() 
    {
        // return a default image placeholder if your source avatar is not found
        $file_name = self::$path.'/if_skype2512x512_197582.png';
        return Yii::$app->urlManager->baseUrl . $file_name;
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
    
    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        
        $fileDirectory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . '/uploads/blog';
        
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content);
        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query("//img") as $node) {

            $poolNode = $node->getAttribute('src');
            if (strpos($poolNode, 'blog/') !== false) {
                
                $image = substr($poolNode, strpos($poolNode, 'blog/'));
                
                $file = $fileDirectory.str_replace('blog', '', $image);
                
                file_exists($file) ? unlink($file) : '' ;
            }
        }        
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
    
    public function configureContentTable(){
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content);
        $xpath = new DOMXPath($dom);

        foreach ($xpath->query("//table") as $node) {
            //UNTUK SETIAP TAG IMAGE, PASANGKAN STYLE CLASS-NYA
            $node->setAttribute("class", "table table-striped");
            $node->setAttribute("style", "");
        }    
        
        return str_replace('%09', '', $dom->saveHtml());        
    }    
    
    
    public static function countByMonthPeriod($year,$month){
   
        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        
        $query  = Blog::find()->where(['month_period'=>$monthPeriod.$year]);    
          
        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;         

    }    
    
    public static function getCounterByMonthPeriod($year,$month){
   
        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        
        $query  = Blog::find()->where(['month_period'=>$monthPeriod.$year]);    
          
        $queryCount = $query->sum('view_counter');
        return (!empty($queryCount)) ? $queryCount: 0 ;         

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
