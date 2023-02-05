<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Lookup;

/**
 * LookupSearch represents the model behind the search form about `backend\models\Lookup`.
 */
class LookupSearch extends Lookup
{
    public function rules()
    {
        return [
            [['id', 'sequence', 'editable'], 'integer'],
            [['title', 'token', 'category', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Lookup::find()->orderBy(['id' => SORT_ASC],['sequece'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sequence' => $this->sequence,
            'editable' => $this->editable,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
