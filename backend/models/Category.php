<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Category as BaseCategory;
use backend\models\Blog as Blog;

/**
 * This is the model class for table "tx_category".
 */
class Category extends BaseCategory
{
    
    const TIME_LINE_NO     = 1;
    const TIME_LINE_YES    = 2;    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sequence', 'time_line', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['label'], 'string', 'max' => 20],
            [['title'], 'unique'],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']      
        ];         
        
    }
	
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (empty($this->time_line)){
            $this->time_line = self::TIME_LINE_NO;
        }
        
        if ($this->time_line==self::TIME_LINE_YES) {
            $categories = Category::find()->where(['<>','id',$this->id])->all();
            foreach ($categories as $categoryModel) {
                $categoryModel->time_line = self::TIME_LINE_NO;
                $categoryModel->save();
            }
        }        

        return true;
    }    
    
    public static function getArrayTimeLine()
    {
        return [
            //MASTER
            self::TIME_LINE_NO      => 'No',
            self::TIME_LINE_YES     => 'Yes',
        ];
    }    
    
    public static function getOneTimeLine($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayTimeLine();
            $returnValue = 'NULL';

            switch ($_module) {
                case ($_module == self::TIME_LINE_NO):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::TIME_LINE_YES):
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
    
    
    public function countAuthorBlog($author){
        return Blog::find()->where
            ([
                'category_id'=>$this->id,
                'author_id'=>$author,
                'publish_status'=>Blog::PUBLISH_STATUS_YES
            ])->count();
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
