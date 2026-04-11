<?php

namespace frontend\models\search;

use common\models\Article;
use common\models\ArticleCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class ArticleSearch extends Article
{
    public $year;
    public $month;

    public function rules(): array
    {
        return [
            [['id', 'category_id', 'year', 'month'], 'integer'],
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
        $query = Article::find()
            ->joinWith('category')
            ->andWhere(['{{%article_category}}.[[status]]' => ArticleCategory::STATUS_ACTIVE])
            ->andWhere(['{{%article}}.[[status]]' => Article::STATUS_PUBLISHED])
            ->andWhere(['<=', '{{%article}}.[[published_at]]', date('Y-m-d H:i:s')])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
        ]);
        $query->andFilterWhere(['YEAR({{%article}}.[[published_at]])' => $this->year]);
        $query->andFilterWhere(['MONTH({{%article}}.[[published_at]])' => $this->month]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
