<?php

namespace backend\modules\widget\models\search;

use common\models\WidgetImage;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ImageSearch extends WidgetImage
{
    public function rules()
    {
        return [
            [['id', 'size', 'sequence'], 'integer'],
            [['key', 'title', 'mime_type', 'base_url', 'path', 'asset_url', 'link_url', 'alt_text'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WidgetImage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'size' => $this->size,
            'sequence' => $this->sequence,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'mime_type', $this->mime_type])
            ->andFilterWhere(['like', 'base_url', $this->base_url])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'asset_url', $this->asset_url])
            ->andFilterWhere(['like', 'link_url', $this->link_url])
            ->andFilterWhere(['like', 'alt_text', $this->alt_text])
        ;

        return $dataProvider;
    }
}
