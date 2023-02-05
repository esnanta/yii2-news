<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ImportData;

/**
 * backend\models\ImportDataSearch represents the model behind the search form about `backend\models\ImportData`.
 */
 class ImportDataSearch extends ImportData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'modul_type', 'row_start', 'row_end', 'create_time', 'update_time', 'create_by', 'update_by', 'verlock'], 'integer'],
            [['title', 'file_name', 'description'], 'safe'],
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
        $query = ImportData::find()->orderBy(['modul_type'=>SORT_ASC]);;

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
            'modul_type' => $this->modul_type,
            'row_start' => $this->row_start,
            'row_end' => $this->row_end,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
