<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AccountPayableDetail;

/**
 * backend\models\AccountPayableDetailSearch represents the model behind the search form about `backend\models\AccountPayableDetail`.
 */
 class AccountPayableDetailSearch extends AccountPayableDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_payable_id', 'account_id', 'verlock'], 'integer'],
            [['invoice', 'commentary'], 'safe'],
            [['amount'], 'number'],
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
        $query = AccountPayableDetail::find();

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
            'account_payable_id' => $this->account_payable_id,
            'account_id' => $this->account_id,
            'amount' => $this->amount,
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'commentary', $this->commentary]);

        return $dataProvider;
    }
}
