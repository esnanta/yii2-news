<?php

namespace common\models;

use common\service\CacheService;
use kartik\daterange\DateRangeBehavior;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class ArticleSearch extends Article
{

    public $date_range;
    public $date_first;
    public $date_last;

    public function behaviors() : array
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'created_at',
                'dateStartAttribute' => 'date_first',
                'dateEndAttribute' => 'date_last',
            ],
        ];
    }

    public function rules() : array
    {
        return [
            [['id', 'office_id', 'article_category_id', 'author_id', 'publish_status', 'pinned_status', 'view_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'cover', 'url', 'content', 'description', 'tags', 'month_period', 'date_issued', 'created_at', 'updated_at', 'deleted_at', 'uuid'], 'safe'],
            [['rating'], 'number'],
            [['date_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $officeId = CacheService::getInstance()->getOfficeId();

        $query = Article::find()
                    ->where(['tx_article.office_id'=>$officeId])
        ->orderBy(['tx_article.created_at' => SORT_DESC]);
        $query->joinWith('articleCategory');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tx_article.id' => $this->id,
            'tx_article.office_id' => $this->office_id,
            'tx_article.article_category_id' => $this->article_category_id,
            'tx_article.author_id' => $this->author_id,
            'tx_article.publish_status' => $this->publish_status,
            'tx_article.pinned_status' => $this->pinned_status,
            'tx_article.view_counter' => $this->view_counter,
            'tx_article.rating' => $this->rating,
            'tx_article.date_issued' => $this->date_issued,
            'tx_article.created_at' => $this->created_at,
            'tx_article.updated_at' => $this->updated_at,
            'tx_article.created_by' => $this->created_by,
            'tx_article.updated_by' => $this->updated_by,
            'tx_article.is_deleted' => $this->is_deleted,
            'tx_article.deleted_at' => $this->deleted_at,
            'tx_article.deleted_by' => $this->deleted_by,
            'tx_article.verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'tx_article.title', $this->title])
            ->andFilterWhere(['like', 'tx_article.cover', $this->cover])
            ->andFilterWhere(['like', 'tx_article.rl', $this->url])
            ->andFilterWhere(['like', 'tx_article.content', $this->content])
            ->andFilterWhere(['like', 'tx_article.description', $this->description])
            ->andFilterWhere(['like', 'tx_article.tags', $this->tags])
            ->andFilterWhere(['like', 'tx_article.month_period', $this->month_period])
            ->andFilterWhere(['like', 'tx_article.uuid', $this->uuid]);

        $query->andFilterWhere(['>=', 'tx_article.date_issued', $this->date_first])
            ->andFilterWhere(['<', 'tx_article.date_issued', $this->date_last]);

        return $dataProvider;
    }
}
