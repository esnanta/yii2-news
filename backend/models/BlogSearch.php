<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Blog;
use kartik\daterange\DateRangeBehavior;

/**
 * BlogSearch represents the model behind the search form about `backend\models\Blog`.
 */
class BlogSearch extends Blog
{
    
    public $date_issued_range;
    public $date_issued_first;
    public $date_issued_last;    
    
    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_issued_range',
                'dateStartAttribute' => 'date_issued_first',
                'dateEndAttribute' => 'date_issued_last',
            ],          
        ];
    }      
    
    public function rules()
    {
        return [
            [['id', 'category_id', 'author_id', 'publish_status', 'pinned_status', 'view_counter', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'cover', 'url', 'content', 'description', 'tags'], 'safe'],
            [['rating'], 'number'],
            
            //TAMBAHAN
            [['date_issued_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Blog::find()->orderBy(['created_at'=>SORT_DESC]);
        $query->joinWith('category');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'author_id' => $this->author_id,
            'publish_status' => $this->publish_status,
            'pinned_status' => $this->pinned_status,
            'view_counter' => $this->view_counter,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,            
        ]);

        $query->andFilterWhere(['like', 'tx_blog.title', $this->title])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tx_blog.description', $this->description])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        $query->andFilterWhere(['>=', 'tx_blog.date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'tx_blog.date_issued', $this->date_issued_last]);  
        
        return $dataProvider;
    }
}
