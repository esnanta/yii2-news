<?php

namespace common\models;

use common\helper\MediaTypeHelper;
use \common\models\base\AuthorMedia as BaseAuthorMedia;

/**
 * This is the model class for table "tx_author_media".
 */
class AuthorMedia extends BaseAuthorMedia
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['office_id', 'author_id', 'media_type', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }

    public static function getArrayMediaType(): array
    {
        return MediaTypeHelper::getArrayMediaType();
    }

    public static function getOneMediaType($_module = null): string
    {
        if($_module)
        {
            return MediaTypeHelper::getOneMediaType($_module);
        }
        else
            return '-';
    }
}
