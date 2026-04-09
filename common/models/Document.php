<?php

namespace common\models;

use common\models\base\Document as BaseDocument;

/**
 * This is the model class for table "t_document".
 */
class Document extends BaseDocument
{
    public function rules(): array
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['office_id', 'is_visible', 'category_id', 'size', 'view_count', 'download_count',
                    'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['description'], 'string'],
                [['title'], 'string', 'max' => 200],
                [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }
}
