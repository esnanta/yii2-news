<?php

namespace common\models\search;

use common\models\Staff;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StaffSearch represents the model behind the search form about `common\models\Staff`.
 */
class StaffSearch extends Staff
{
    public function rules(): array
    {
        return [
            [['id', 'office_id', 'employment_id', 'gender_status', 'active_status', 'size', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'initial', 'identity_number', 'phone_number', 'address', 'base_url', 'path', 'name', 'type', 'email', 'description', 'created_at', 'updated_at', 'deleted_at', 'uuid'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Staff::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'office_id' => $this->office_id,
            'employment_id' => $this->employment_id,
            'gender_status' => $this->gender_status,
            'active_status' => $this->active_status,
            'size' => $this->size,
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
            ->andFilterWhere(['like', 'initial', $this->initial])
            ->andFilterWhere(['like', 'identity_number', $this->identity_number])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'base_url', $this->base_url])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'uuid', $this->uuid])
        ;

        return $dataProvider;
    }
}
