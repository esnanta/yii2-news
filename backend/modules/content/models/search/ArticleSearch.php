<?php

namespace backend\modules\content\models\search;

use common\models\Article;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    public function rules(): array
    {
        return [
            [['id', 'category_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['published_at', 'created_at', 'updated_at', 'slug', 'title', 'body'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'slug' => $this->slug,
            'created_by' => $this->created_by,
            'category_id' => $this->category_id,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['DATE({{%article}}.[[published_at]])' => $this->published_at]);
        $query->andFilterWhere(['DATE({{%article}}.[[created_at]])' => $this->created_at]);
        $query->andFilterWhere(['DATE({{%article}}.[[updated_at]])' => $this->updated_at]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
        ;

        return $dataProvider;
    }
}
