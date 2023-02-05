<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OutletDetail;

/**
 * OutletDetailSearch represents the model behind the search form about `backend\models\OutletDetail`.
 */
class OutletDetailSearch extends OutletDetail
{
    
    public $address;
    public $customer_title;
    public $customer_number;
    public $phone_number;    
    public $invoice;   
    
    public function rules()
    {
        return [
            
            [['invoice','customer_title','address','customer_number','phone_number'], 'safe'],
            
            [['id', 'outlet_id', 'customer_id', 'enrolment_type', 'device_type', 'device_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['assembly_cost', 'monthly_bill'], 'number'],
            [['description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OutletDetail::find()->orderBy(['created_at'=>SORT_DESC]);
        $query->joinWith(['customer', 'enrolment','outlet']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'outlet_id' => $this->outlet_id,
            'customer_id' => $this->customer_id,
            'assembly_cost' => $this->assembly_cost,
            'monthly_bill' => $this->monthly_bill,
            'enrolment_type' => $this->enrolment_type,
            'device_type' => $this->device_type,
            'device_status' => $this->device_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by, 
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'tx_outlet_detail.description', $this->description])
            ->andFilterWhere(['like', 'tx_outlet.invoice', $this->invoice])
            ->andFilterWhere(['like', 'tx_enrolment.title', $this->customer_number])
            ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title])                   
            ->andFilterWhere(['like', 'tx_customer.phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'tx_customer.address', $this->address]);                  
                
                

        return $dataProvider;
    }
}
