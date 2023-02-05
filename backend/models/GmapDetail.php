<?php

namespace backend\models;

use Yii;
use \backend\models\base\GmapDetail as BaseGmapDetail;

/**
 * This is the model class for table "tx_gmap_detail".
 */
class GmapDetail extends BaseGmapDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['gmap_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['latitude', 'longitude'], 'string', 'max' => 30],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
