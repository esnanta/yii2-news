<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ValidityDetail;
use kartik\daterange\DateRangeBehavior;

/**
 * ValidityDetailSearch represents the model behind the search form about `backend\models\ValidityDetail`.
 */
class ValidityDetailSearch extends ValidityDetail
{
    
    public $date_due_range;
    public $date_due_first;
    public $date_due_last;       
    
    public $validity_title;
    public $customer_title;
    public $enrolment_title;    
    
    public function behaviors()
    {
        return [
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
            
            [['validity_title','customer_title', 'enrolment_title'], 'safe'],            
            
            [['id', 'validity_id', 'customer_id', 'device_status', 'billing_status', 'date_due', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['amount'], 'number'],
            [['month_period', 'description'], 'safe'],
            [['date_due_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params,$validityId=null)
    {
        //$query = ValidityDetail::find()->where(['validity_id'=>$validityId])->orderBy(['created_at'=>SORT_DESC]);
        $query = ValidityDetail::find()->orderBy(['created_at'=>SORT_DESC]);
        $query->joinWith(['validity', 'customer', 'enrolment']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'validity_id' => $this->validity_id,
            'customer_id' => $this->customer_id,
            'device_status' => $this->device_status,
            'billing_status' => $this->billing_status,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by, 
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'month_period', $this->month_period])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tx_validity.title', $this->validity_title])
            ->andFilterWhere(['like', 'tx_enrolment.title', $this->enrolment_title])
            ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title]);                  
                
        $query->andFilterWhere(['>=', 'date_due', $this->date_due_first])
              ->andFilterWhere(['<', 'date_due', $this->date_due_last]);            

        return $dataProvider;
    }
}
