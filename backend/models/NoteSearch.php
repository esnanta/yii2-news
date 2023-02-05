<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Note;
use kartik\daterange\DateRangeBehavior;

/**
 * NoteSearch represents the model behind the search form about `backend\models\Note`.
 */
class NoteSearch extends Note
{
    
    public $date_issued_range;
    public $date_issued_first;
    public $date_issued_last;    
    
    public $date_due_range;
    public $date_due_first;
    public $date_due_last;      
    
    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_issued_range',
                'dateStartAttribute' => 'date_issued_first',
                'dateEndAttribute' => 'date_issued_last',
            ],
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_due_range',
                'dateStartAttribute' => 'date_due_first',
                'dateEndAttribute' => 'date_due_last',
            ],            
        ];
    }     
    
    public function rules()
    {
        return [
            [['id', 'note_type_id', 'staff_id','date_issued', 'date_due', 'created_at', 'updated_at', 'created_by', 'updated_by', 'verlock'], 'integer'],
            [['title', 'description'], 'safe'],
            [['date_issued_range', 'date_due_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Note::find()->orderBy(['created_at'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'note_type_id' => $this->note_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        $query->andFilterWhere(['>=', 'date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'date_issued', $this->date_issued_last]);      
        
        $query->andFilterWhere(['>=', 'date_due', $this->date_due_first])
              ->andFilterWhere(['<', 'date_due', $this->date_due_last]);          
        
        return $dataProvider;
    }
}
