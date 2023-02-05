<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AccountReceivableDetail;

/**
 * backend\models\AccountReceivableDetailSearch represents the model behind the search form about `backend\models\AccountReceivableDetail`.
 */
 class AccountReceivableDetailSearch extends AccountReceivableDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_receivable_id', 'account_id'], 'integer'],
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
        $query = AccountReceivableDetail::find();

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
            'account_receivable_id' => $this->account_receivable_id,
            'account_id' => $this->account_id,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'commentary', $this->commentary]);

        return $dataProvider;
    }
}
