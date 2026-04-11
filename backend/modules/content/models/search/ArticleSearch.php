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
            [['id', 'author_id', 'category_id', 'created_by', 'updated_by', 'is_pinned'], 'integer'],
            ['status', 'in', 'range' => array_keys(Article::statuses())],
            [['published_at', 'created_at', 'updated_at', 'slug', 'title', 'body'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
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

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $publishedAt = $this->normalizeDateTime($this->published_at);
        $createdAt = $this->normalizeDate($this->created_at);
        $updatedAt = $this->normalizeDate($this->updated_at);

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'is_pinned' => $this->is_pinned,
        ]);

        $query->andFilterWhere(['{{%article}}.[[published_at]]' => $publishedAt]);
        $query->andFilterWhere(['DATE({{%article}}.[[created_at]])' => $createdAt]);
        $query->andFilterWhere(['DATE({{%article}}.[[updated_at]])' => $updatedAt]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }

    private function normalizeDate(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        $normalizedDate = str_replace('/', '-', $date);
        $parsed = \DateTime::createFromFormat('d-m-Y', $normalizedDate);

        return $parsed ? $parsed->format('Y-m-d') : $date;
    }

    private function normalizeDateTime(?string $dateTime): ?string
    {
        if (empty($dateTime)) {
            return null;
        }

        $normalized = str_replace('T', ' ', $dateTime);
        if (preg_match('/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/', $normalized) === 1) {
            $normalized .= ':00';
        }

        $withSeconds = \DateTime::createFromFormat('Y-m-d H:i:s', $normalized);
        if ($withSeconds !== false) {
            return $withSeconds->format('Y-m-d H:i:s');
        }

        $withoutSeconds = \DateTime::createFromFormat('Y-m-d H:i', $normalized);
        if ($withoutSeconds !== false) {
            return $withoutSeconds->format('Y-m-d H:i:s');
        }

        return $dateTime;
    }
}
