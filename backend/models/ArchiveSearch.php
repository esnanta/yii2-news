<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Archive;

/**
 * backend\models\ArchiveSearch represents the model behind the search form about `backend\models\Archive`.
 */
 class ArchiveSearch extends Archive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_visible', 'archive_type', 'archive_category_id', 'size', 'view_counter', 'download_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'date_issued', 'file_name', 'archive_url', 'mime_type', 'description', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Archive::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_visible' => $this->is_visible,
            'archive_type' => $this->archive_type,
            'archive_category_id' => $this->archive_category_id,
            'date_issued' => $this->date_issued,
            'size' => $this->size,
            'view_counter' => $this->view_counter,
            'download_counter' => $this->download_counter,
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
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'archive_url', $this->archive_url])
            ->andFilterWhere(['like', 'mime_type', $this->mime_type])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
