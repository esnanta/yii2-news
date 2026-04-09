<?php

namespace common\models\search;

use common\models\SocialPlatform;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SocialPlatformSearch represents the model behind the search form about `common\models\SocialPlatform`.
 */
class SocialPlatformSearch extends SocialPlatform
{
    public function rules(): array
    {
        return [
            [['id', 'is_active', 'sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['code', 'name', 'base_url', 'created_at', 'updated_at', 'deleted_at', 'uuid'], 'safe'],
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
        $query = SocialPlatform::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
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

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'base_url', $this->base_url])
            ->andFilterWhere(['like', 'uuid', $this->uuid])
        ;

        return $dataProvider;
    }
}
