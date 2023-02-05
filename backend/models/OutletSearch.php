<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\models\Outlet;
use kartik\daterange\DateRangeBehavior;

/**
 * backend\models\OutletSearch represents the model behind the search form about `backend\models\Outlet`.
 */
 class OutletSearch extends Outlet
{
     
    public $date_issued_range;
    public $date_issued_first;
    public $date_issued_last;    
    
    public $date_assembly_range;
    public $date_assembly_first;
    public $date_assembly_last;           
     
    public $customer_title;
    public $customer_number;    
    public $staff_title;    
    
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
                'attribute' => 'date_assembly_range',
                'dateStartAttribute' => 'date_assembly_first',
                'dateEndAttribute' => 'date_assembly_last',
            ],            
        ];
    }        
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['customer_title', 'customer_number','staff_title'], 'safe'],
            
            [['id', 'customer_id', 'staff_id', 'date_issued', 'date_assembly', 'billing_status', 'assembly_type', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'invoice', 'description'], 'safe'],
            [['claim'], 'number'],
            [['date_issued_range', 'date_assembly_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
        $query = Outlet::find()->orderBy(['date_issued'=>SORT_DESC]);
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
            'billing_status' => $this->billing_status,
            'assembly_type' => $this->assembly_type,
            'claim' => $this->claim,
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
            ->andFilterWhere(['like', 'description', $this->description]);

        $query->andFilterWhere(['>=', 'date_issued', $this->date_issued_first])
              ->andFilterWhere(['<', 'date_issued', $this->date_issued_last]);      
        
        $query->andFilterWhere(['like', 'tx_enrolment.title', $this->customer_number])
            ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title])
            ->andFilterWhere(['like', 'tx_staff.title', $this->staff_title]);         
        
        $query->andFilterWhere(['>=', 'date_assembly', $this->date_assembly_first])
              ->andFilterWhere(['<', 'date_assembly', $this->date_assembly_last]);           
        
        return $dataProvider;
    }
}
