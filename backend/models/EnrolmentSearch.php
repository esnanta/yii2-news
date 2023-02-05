<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Enrolment;
use kartik\daterange\DateRangeBehavior;

/**
 * EnrolmentSearch represents the model behind the search form about `backend\models\Enrolment`.
 */
class EnrolmentSearch extends Enrolment
{

    public $date_effective_range;
    public $date_effective_first;
    public $date_effective_last;

    public $date_start_range;
    public $date_start_first;
    public $date_start_last;

    public $date_end_range;
    public $date_end_first;
    public $date_end_last;

    public $area_id;
    public $village_id;
    public $customer_title;
    public $customer_phone_number;
    public $customer_address;

    public $days_of_valid;
    public $days_of_expired;
    
    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_effective_range',
                'dateStartAttribute' => 'date_effective_first',
                'dateEndAttribute' => 'date_effective_last',
            ],
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_start_range',
                'dateStartAttribute' => 'date_start_first',
                'dateEndAttribute' => 'date_start_last',
            ],
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_end_range',
                'dateStartAttribute' => 'date_end_first',
                'dateEndAttribute' => 'date_end_last',
            ],
        ];
    }

    public function rules()
    {
        return [

            [['customer_title','customer_phone_number','customer_address',
                'days_of_valid','days_of_expired'], 'safe'],

            [['area_id','village_id'], 'integer'],

            [['network_id', 'customer_id', 'date_effective', 'enrolment_type', 
                'date_start', 'date_end', 'created_at', 'updated_at', 'created_by', 'updated_by', 
                'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            
            [['title', 'billing_cycle', 'description'], 'safe'],
            [['date_effective_range','date_start_range','date_end_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Enrolment::find()->orderBy(['created_at'=>SORT_DESC]);
        $query->joinWith(['customer']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,

            'tx_customer.area_id' => $this->area_id,
            'tx_customer.village_id' => $this->village_id,

            'customer_id' => $this->customer_id,
            'network_id' => $this->network_id,
            'billing_cycle' => $this->billing_cycle,
            'enrolment_type' => $this->enrolment_type,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
            'verlock' => $this->verlock,
            
            'DATEDIFF(FROM_UNIXTIME(date_end), FROM_UNIXTIME(date_start))' => $this->days_of_valid,
            'DATEDIFF(NOW(), FROM_UNIXTIME(date_end))' => $this->days_of_expired
        ]);

        $query->andFilterWhere(['like', 'tx_enrolment.title', $this->title])
                ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title])
                ->andFilterWhere(['like', 'tx_customer.address', $this->customer_address])
                ->andFilterWhere(['like', 'tx_customer.phone_number', $this->customer_phone_number]);

        $query->andFilterWhere(['>=', 'tx_enrolment.date_effective', $this->date_effective_first])
              ->andFilterWhere(['<', 'tx_enrolment.date_effective', $this->date_effective_last]);

        $query->andFilterWhere(['>=', 'tx_enrolment.date_start', $this->date_start_first])
              ->andFilterWhere(['<', 'tx_enrolment.date_start', $this->date_start_last]);

        $query->andFilterWhere(['>=', 'tx_enrolment.date_end', $this->date_end_first])
              ->andFilterWhere(['<', 'tx_enrolment.date_end', $this->date_end_last]);


        return $dataProvider;
    }
}
