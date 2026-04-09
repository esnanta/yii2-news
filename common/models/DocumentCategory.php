<?php

namespace common\models;

use common\models\base\DocumentCategory as BaseDocumentCategory;

/**
 * This is the model class for table "t_document_category".
 */
class DocumentCategory extends BaseDocumentCategory
{
    public function rules(): array
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['office_id', 'sequence', 'created_by', 'updated_by', 'is_deleted',
                    'deleted_by', 'verlock'], 'integer'],
                [['description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title'], 'string', 'max' => 200],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }
}
