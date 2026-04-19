<?php

namespace common\models;

use common\models\base\DocumentCategory as BaseDocumentCategory;
use common\models\query\DocumentCategoryQuery;

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

    /**
     * @return DocumentCategoryQuery the active query used by this AR class
     */
    public static function find(): DocumentCategoryQuery
    {
        $query = new DocumentCategoryQuery(get_called_class());

        return $query->where(['t_document_category.is_deleted' => 0]);
    }
}
