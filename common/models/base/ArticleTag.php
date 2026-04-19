<?php

namespace common\models\base;

use common\base\BaseActiveRecord;
use common\models\Article;
use common\models\Tag;
use mootensai\relation\RelationTrait;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "t_article_tag".
 *
 * @property int     $article_id
 * @property int     $tag_id
 * @property Article $article
 * @property Tag     $tag
 */
class ArticleTag extends BaseActiveRecord
{
    use RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster.
     *
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'article',
            'tag',
        ];
    }

    public function rules(): array
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer'],
        ];
    }

    public static function tableName(): string
    {
        return 't_article_tag';
    }

    public function attributeLabels(): array
    {
        return [
            'article_id' => \Yii::t('common', 'Article'),
            'tag_id' => \Yii::t('common', 'Tag'),
        ];
    }

    public function getArticle(): ActiveQuery
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
