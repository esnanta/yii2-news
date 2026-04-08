<?php

namespace backend\modules\content\models\search;

use common\models\ArticleCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ArticleCategorySearch extends ArticleCategory
{
    public function rules(): array
    {
        return [
            [['id', 'parent_id', 'status'], 'integer'],
            [['slug', 'title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param mixed $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
        ;

        return $dataProvider;
    }
}
