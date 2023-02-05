<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AccountPayable;
use kartik\daterange\DateRangeBehavior;

/**
 * backend\models\AccountPayableSearch represents the model behind the search form about `backend\models\AccountPayable`.
 */
 class AccountPayableSearch extends AccountPayable
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
     
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'date_issued', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'invoice', 'month_period', 'description'], 'safe'],
            [['claim', 'surcharge', 'penalty', 'total', 'discount', 'payment', 'balance'], 'number'],
            [['date_issued_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AccountPayable::find()->orderBy(['date_issued'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'date_issued' => $this->date_issued,
            'claim' => $this->claim,
            'surcharge' => $this->surcharge,
            'penalty' => $this->penalty,
            'total' => $this->total,
            'discount' => $this->discount,
            'payment' => $this->payment,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by, 
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'month_period', $this->month_period])
            ->andFilterWhere(['like', 'description', $this->description]);

        $query->andFilterWhere(['>=', 'date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'date_issued', $this->date_issued_last]); 
        
        return $dataProvider;
    }
}
