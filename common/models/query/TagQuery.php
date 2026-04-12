<?php

namespace common\models\query;

use common\models\Article;
use common\models\Tag;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [Tag].
 *
 * @see Tag
 */
class TagQuery extends ActiveQuery
{
    public function notDeleted(): self
    {
        return $this->andWhere(['{{%tags}}.[[is_deleted]]' => 0]);
    }

    public function withPublishedArticles(): self
    {
        return $this
            ->innerJoin('{{%article_tag}}', '{{%article_tag}}.[[tag_id]] = {{%tags}}.[[id]]')
            ->innerJoin('{{%article}}', '{{%article}}.[[id]] = {{%article_tag}}.[[article_id]]')
            ->andWhere([
                '{{%article}}.[[is_deleted]]' => 0,
                '{{%article}}.[[status]]' => Article::STATUS_PUBLISHED,
            ])
            ->andWhere(['<=', '{{%article}}.[[published_at]]', date('Y-m-d H:i:s')])
        ;
    }
}
