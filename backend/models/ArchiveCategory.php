<?php

namespace backend\models;

use Yii;
use \backend\models\base\ArchiveCategory as BaseArchiveCategory;

/**
 * This is the model class for table "tx_archive_category".
 */
class ArchiveCategory extends BaseArchiveCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
