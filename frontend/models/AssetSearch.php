<?php

namespace frontend\models;


use common\models\Asset;
use common\models\AssetSearch as baseAssetSearch;
use common\service\CacheService;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * ArchiveSearch represents the model behind the search form about `common\models\Archive`.
 */
class AssetSearch extends baseAssetSearch
{

    public function search($params): ActiveDataProvider
    {
        $officeId = CacheService::getInstance()->getOfficeId();
        $query = Asset::find()->where(['office_id'=>$officeId])
                    ->andWhere(['is_visible'=>Asset::IS_VISIBLE_PUBLIC])
                    ->orderBy(['created_at' => SORT_DESC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'office_id' => $this->office_id,
            'is_visible' => $this->is_visible,
            'asset_type' => $this->asset_type,
            'asset_category_id' => $this->asset_category_id,
            'date_issued' => $this->date_issued,
            'size' => $this->size,
            'view_counter' => $this->view_counter,
            'download_counter' => $this->download_counter,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
            'verlock' => $this->verlock,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'asset_name', $this->asset_name])
            ->andFilterWhere(['like', 'asset_url', $this->asset_url])
            ->andFilterWhere(['like', 'mime_type', $this->mime_type])
            ->andFilterWhere(['like', 'description', $this->description]);

        if($this->date_first!=null && $this->date_last!=null):
            $query->andFilterWhere(['>=', 'created_at', date(Yii::$app->params['dateSaveFormat'].' 00:00:00', $this->date_first)])
                  ->andFilterWhere(['<', 'created_at', date(Yii::$app->params['dateSaveFormat'].' 23:59:59', $this->date_last)]);  
        endif;
        
        return $dataProvider;
    }
}
