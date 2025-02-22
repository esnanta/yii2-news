<?php

namespace common\models;

use common\service\CacheService;
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
            [['employment_id', 'gender_status', 'active_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'identity_number', 'initial', 'phone_number', 'address', 'asset_name', 'email', 'google_plus', 'instagram', 'facebook', 'twitter', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $officeId = CacheService::getInstance()->getOfficeId();
        $query = Staff::find()
            ->where(['office_id'=>$officeId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'employment_id' => $this->employment_id,
            'gender_status' => $this->gender_status,
            'active_status' => $this->active_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'identity_number', $this->identity_number])
            ->andFilterWhere(['like', 'initial', $this->initial])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'asset_name', $this->asset_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'google_plus', $this->google_plus])
            ->andFilterWhere(['like', 'instagram', $this->instagram])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
