<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ThemeDetail;
use backend\models\Theme;

/**
 * ThemeDetailSearch represents the model behind the search form about `backend\models\ThemeDetail`.
 */
class ThemeDetailSearch extends ThemeDetail
{
    public function rules()
    {
        return [
            [['theme_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['token', 'title', 'content', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ThemeDetail::find()
                //->where(['theme_id'=>Theme::getIdByTitle(Yii::$app->params['Theme_Active'])])
                //->orWhere(['theme_id'=>Theme::getIdByTitle(Yii::$app->params['Theme_Global'])])
                ->orderBy(['token' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            //'content_id' => $this->content_id,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'description', $this->description]);
 
        return $dataProvider;
    }
}
