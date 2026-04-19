<?php

namespace common\models;

use common\models\base\ArticleTag as BaseArticleTag;

/**
 * This is the model class for table "t_article_tag".
 */
class ArticleTag extends BaseArticleTag
{
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['article_id', 'tag_id'], 'required'],
                [['article_id', 'tag_id'], 'integer'],
            ]
        );
    }
}
