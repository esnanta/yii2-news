<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Archive;
use kartik\daterange\DateRangeBehavior;
/**
 * ArchiveSearch represents the model behind the search form about `backend\models\Archive`.
 */
class ArchiveSearch extends Archive
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
            
            //TAMBAHAN
            [['date_issued_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            
            [['date_issued', 'size', 'view_counter', 'download_counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'is_visible','archive_category_id','file_name', 'archive_url', 'mime_type', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Archive::find()->orderBy(['created_at'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'size' => $this->size,
            'is_visible' => $this->is_visible,
            'archive_category_id' => $this->archive_category_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'archive_url', $this->archive_url])
            ->andFilterWhere(['like', 'mime_type', $this->mime_type])
            ->andFilterWhere(['like', 'description', $this->description]);
        
        $query->andFilterWhere(['>=', 'tx_mail_disposition.date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'tx_mail_disposition.date_issued', $this->date_issued_last]); 
        
        return $dataProvider;
    }   
}
