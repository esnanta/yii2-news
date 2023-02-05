<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Billing;
use kartik\daterange\DateRangeBehavior;

/**
 * BillingSearch represents the model behind the search form about `backend\models\Billing`.
 */
class BillingSearch extends Billing
{
    public $customer_number;
    public $customer_title;
    public $phone_number;
    public $address;

    public $date_due_range;
    public $date_due_first;
    public $date_due_last;


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
            [['id', 'customer_id', 'area_id', 'date_issued', 'date_due', 'billing_type', 'payment_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'invoice', 'month_period', 'description'], 'safe'],
            [['amount'], 'number'],

            //TAMBAHAN
            [['customer_title', 'customer_number', 'phone_number','address'], 'safe'],

            [['date_due_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Billing::find()->orderBy(['date_issued'=>SORT_DESC]);
        $query->joinWith(['customer', 'enrolment']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        // Important: here is how we set up the sorting
        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['customer'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['tx_customer.phone_number' => SORT_ASC],
            'desc' => ['tx_customer.phone_number' => SORT_DESC],
        ];

        // Lets do the same with country now
        $dataProvider->sort->attributes['enrolment'] = [
            'asc' => ['tx_enrolment.title' => SORT_ASC],
            'desc' => ['tx_enrolment.title' => SORT_DESC],
        ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tx_billing.id' => $this->id,
            'tx_billing.customer_id' => $this->customer_id, //CHANGE
            'tx_billing.area_id' => $this->area_id, //CHANGE
            'tx_billing.amount' => $this->amount,
            'tx_billing.date_issued' => $this->date_issued,
            'tx_billing.date_due' => $this->date_due,
            'tx_billing.billing_type' => $this->billing_type,
            'tx_billing.payment_status' => $this->payment_status,
            'tx_billing.created_at' => $this->created_at,
            'tx_billing.updated_at' => $this->updated_at,
            'tx_billing.created_by' => $this->created_by,
            'tx_billing.updated_by' => $this->updated_by,
            'tx_billing.verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'tx_billing.title', $this->title]) //CHANGE
            ->andFilterWhere(['like', 'tx_billing.invoice', $this->invoice])
            ->andFilterWhere(['like', 'tx_billing.month_period', $this->month_period])
            ->andFilterWhere(['like', 'tx_billing.description', $this->description])


            ->andFilterWhere(['like', 'tx_enrolment.title', $this->customer_number])
            ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title])
            ->andFilterWhere(['like', 'tx_customer.address', $this->address])
            ->andFilterWhere(['like', 'tx_customer.phone_number', $this->phone_number]);


        $query->andFilterWhere(['>=', 'tx_billing.date_due', $this->date_due_first])
              ->andFilterWhere(['<', 'tx_billing.date_due', $this->date_due_last]);

        return $dataProvider;
    }
}
