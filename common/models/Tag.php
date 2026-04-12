<?php

namespace common\models;

use common\models\base\Tag as BaseTag;
use common\models\query\TagQuery;
use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

class Tag extends BaseTag
{
    public static function find(): TagQuery
    {
        return new TagQuery(static::class);
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['frequency', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['slug'], 'string', 'max' => 100],
            [['uuid'], 'string', 'max' => 36],
            [['slug'], 'unique'],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => static fn (): string => date('Y-m-d H:i:s'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(Article::class, ['id' => 'article_id'])
            ->viaTable('{{%article_tag}}', ['tag_id' => 'id'])
        ;
    }

    /**
     * Returns most used tags with a usage count calculated from the pivot table.
     */
    public static function findTagWeights(int $limit = 8): array
    {
        return static::find()
            ->notDeleted()
            ->withPublishedArticles()
            ->select([
                '{{%tags}}.[[title]]',
                '{{%tags}}.[[slug]]',
                'COUNT({{%article_tag}}.[[article_id]]) AS [[weight]]',
            ])
            ->groupBy(['{{%tags}}.[[id]]', '{{%tags}}.[[title]]', '{{%tags}}.[[slug]]'])
            ->orderBy(['weight' => SORT_DESC, '{{%tags}}.[[title]]' => SORT_ASC])
            ->limit($limit)
            ->asArray()
            ->all()
        ;
    }
}
