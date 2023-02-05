<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ServiceDetail;

/**
 * ServiceDetailSearch represents the model behind the search form about `backend\models\ServiceDetail`.
 */
class ServiceDetailSearch extends ServiceDetail
{
    public $title;   
    
    public function rules()
    {
        return [
            [['title'], 'safe'],
            
            [['id', 'service_id', 'outlet_detail_id', 'service_reason_id', 'device_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['month_period', 'commentary'], 'safe'],
            [['claim'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ServiceDetail::find()->orderBy(['tx_service_detail.created_at'=>SORT_DESC]);
        $query->joinWith(['service']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tx_service_detail.service_id' => $this->service_id,
            'tx_service_detail.outlet_detail_id' => $this->outlet_detail_id,
            'tx_service_detail.service_reason_id' => $this->service_reason_id,
            'tx_service_detail.device_status' => $this->device_status,
            'tx_service_detail.claim' => $this->claim,
            'tx_service_detail.created_at' => $this->created_at,
            'tx_service_detail.updated_at' => $this->updated_at,
            'tx_service_detail.created_by' => $this->created_by,
            'tx_service_detail.updated_by' => $this->updated_by,
            'tx_service_detail.is_deleted' => $this->is_deleted,
            'tx_service_detail.deleted_at' => $this->deleted_at,
            'tx_service_detail.deleted_by' => $this->deleted_by, 
            'tx_service_detail.verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'tx_service_detail.month_period', $this->month_period])
            ->andFilterWhere(['like', 'tx_service_detail.commentary', $this->commentary])
            ->andFilterWhere(['like', 'tx_service.title', $this->title]);

        return $dataProvider;
    }
}
