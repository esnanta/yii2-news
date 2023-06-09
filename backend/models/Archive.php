<?php

namespace backend\models;

use Yii;
use \backend\models\base\Archive as BaseArchive;

/**
 * This is the model class for table "tx_archive".
 */
class Archive extends BaseArchive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['is_visible', 'archive_type', 'archive_category_id', 'size', 'view_counter', 'download_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['description'], 'string'],
            [['title', 'file_name'], 'string', 'max' => 200],
            [['archive_url'], 'string', 'max' => 500],
            [['mime_type'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
