<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customer;
use kartik\daterange\DateRangeBehavior;

/**
 * CustomerSearch represents the model behind the search form about `backend\models\Customer`.
 */
class CustomerSearch extends Customer
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
            [['area_id', 'village_id', 'gender_status', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['customer_number', 'identity_number', 'title', 'address', 'phone_number'], 'safe'],
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
        $query = Customer::find()->orderBy(['date_issued'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'area_id' => $this->area_id,
            'village_id' => $this->village_id,
            'gender_status' => $this->gender_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by, 
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'customer_number', $this->customer_number])
            ->andFilterWhere(['like', 'identity_number', $this->identity_number])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number]);

        $query->andFilterWhere(['>=', 'date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'date_issued', $this->date_issued_last]);            
        
        return $dataProvider;
    }
}
