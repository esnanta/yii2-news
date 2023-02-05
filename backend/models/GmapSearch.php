<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Gmap;

/**
 * backend\models\GmapSearch represents the model behind the search form about `backend\models\Gmap`.
 */
 class GmapSearch extends Gmap
{
    public $customer_title;
    public $enrolment_title;
    public $phone_number;
    public $address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],

            //TAMBAHAN
            [['customer_title','enrolment_title', 'phone_number','address'], 'safe'],

            [['latitude', 'longitude', 'description'], 'safe'],
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
        $query = Gmap::find()->orderBy(['created_at'=>SORT_DESC]);
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


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tx_gmap.customer_id' => $this->customer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by, 
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'description', $this->description])

            ->andFilterWhere(['like', 'tx_customer.title', $this->customer_title])
            ->andFilterWhere(['like', 'tx_enrolment.title', $this->enrolment_title])
            ->andFilterWhere(['like', 'tx_customer.address', $this->address])
            ->andFilterWhere(['like', 'tx_customer.phone_number', $this->phone_number]);

        return $dataProvider;
    }
}
