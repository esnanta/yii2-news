<?php

namespace common\models;

use common\helper\LabelHelper;
use common\models\base\ArticleCategory as BaseArticleCategory;
use common\models\Article as Article;

/**
 * This is the model class for table "tx_category".
 */
class ArticleCategory extends BaseArticleCategory
{
    
    const TIME_LINE_NO     = 1;
    const TIME_LINE_YES    = 2;    
    
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['office_id', 'sequence', 'time_line', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['label'], 'string', 'max' => 20],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
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
            $categories = ArticleCategory::find()->where(['<>','id',$this->id])->all();
            foreach ($categories as $categoryModel) {
                $categoryModel->time_line = self::TIME_LINE_NO;
                $categoryModel->save();
            }
        }        

        return true;
    }    
    
    public static function getArrayTimeLine(): array
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

            switch ($_module) {
                case ($_module == self::TIME_LINE_NO):
                    $returnValue = LabelHelper::getDanger($arrayModule[$_module]);
                    break;
                case ($_module == self::TIME_LINE_YES):
                    $returnValue = LabelHelper::getPrimary($arrayModule[$_module]);
                    break;
                default:
                    $returnValue = LabelHelper::getDefault();
            }

            return $returnValue;

        }
        else
            return;
    }        
    
    
    public function countAuthorBlog($author){
        return Article::find()->where
            ([
                'article_category_id'=>$this->id,
                'author_id'=>$author,
                'publish_status'=>Article::PUBLISH_STATUS_YES
            ])->count();
    }
}
