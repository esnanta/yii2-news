<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Service;
use kartik\daterange\DateRangeBehavior;

/**
 * backend\models\ServiceSearch represents the model behind the search form about `backend\models\Service`.
 */
 class ServiceSearch extends Service
{
    
    public $address;
    public $customer_title;
    public $customer_number;
    public $phone_number;
    
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
            
            [['customer_title','address','customer_number','phone_number'], 'safe'],
            
            [['customer_id', 'staff_id', 'date_issued', 'date_effective', 
                'service_type', 'date_start', 'date_end', 'billing_cycle', 
                'created_at', 'updated_at', 'created_by', 'updated_by', 
                'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            
            [['title', 'invoice','description'], 'safe'],
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
        $query = Service::find()->orderBy(['date_issued'=>SORT_DESC]);
        $query->joinWith(['customer', 'enrolment','staff']);
        
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
            'customer_id' => $this->customer_id,
            'staff_id' => $this->staff_id,
            'date_issued' => $this->date_issued,
            'date_effective' => $this->date_effective,
            'service_type' => $this->service_type,
            'billing_cycle' => $this->billing_cycle, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by, 
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'tx_service.title', $this->title])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'description', $this->description])
        
            ->andFilterWhere(['like', 'tx_enrolment.title', $this->customer_number])
            ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title])                   
            ->andFilterWhere(['like', 'tx_customer.phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'tx_customer.address', $this->address]);             
        
        $query->andFilterWhere(['>=', 'tx_service.date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'tx_service.date_issued', $this->date_issued_last]);  
        
        return $dataProvider;
    }
}
