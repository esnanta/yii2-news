<?php

namespace common\models\search;

use common\models\OfficeSocialAccount;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OfficeSocialAccountSearch represents the model behind the search form about `common\models\OfficeSocialAccount`.
 */
class OfficeSocialAccountSearch extends OfficeSocialAccount
{
    public function rules(): array
    {
        return [
            [['id', 'office_id', 'platform_id', 'is_primary', 'is_visible', 'sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['username', 'profile_url', 'description', 'created_at', 'updated_at', 'deleted_at', 'uuid'], 'safe'],
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
        $query = OfficeSocialAccount::find();

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
            'platform_id' => $this->platform_id,
            'is_primary' => $this->is_primary,
            'is_visible' => $this->is_visible,
            'sequence' => $this->sequence,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'profile_url', $this->profile_url])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'uuid', $this->uuid])
        ;

        return $dataProvider;
    }
}
