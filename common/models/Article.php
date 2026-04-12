<?php

namespace common\models;

use common\models\base\Article as BaseArticle;
use common\models\query\ArticleQuery;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * @property string      $tagKeywordString
 * @property ActiveQuery $updater
 */
class Article extends BaseArticle
{
    public const STATUS_PUBLISHED = 1;
    public const STATUS_DRAFT = 0;

    public array $attachments = [];

    public ?array $thumbnail = null;

    /**
     * Editable tag input from form. Pivot table remains the single source of truth.
     *
     * @var array<int, string>
     */
    public array $tagTitles = [];

    /**
     * @return array statuses list
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT => \Yii::t('common', 'Draft'),
            self::STATUS_PUBLISHED => \Yii::t('common', 'Published'),
        ];
    }

    /**
     * @return array pinning options
     */
    public static function pinnedOptions(): array
    {
        return [
            1 => \Yii::t('common', 'Yes'),
            0 => \Yii::t('common', 'No'),
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => static function (): string {
                    return date('Y-m-d H:i:s');
                },
            ],
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'articleAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url',
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['attachments', 'thumbnail'], 'safe'],
            [['tagTitles'], 'default', 'value' => []],
            [['tagTitles'], 'each', 'rule' => ['string', 'max' => 150]],
            [['author_id', 'category_id', 'status',
                'created_by', 'updated_by', 'is_pinned', 'is_deleted',
                'deleted_by', 'verlock'], 'integer'],
            [['slug', 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['published_at'], 'filter', 'filter' => fn ($value) => $this->normalizeDateTimeInput($value)],
            [['published_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['slug', 'view'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 512],
            [['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['uuid'], 'string', 'max' => 36],
            [['slug'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'author_id' => \Yii::t('common', 'Author'),
            'slug' => \Yii::t('common', 'Slug'),
            'title' => \Yii::t('common', 'Title'),
            'tagTitles' => \Yii::t('common', 'Tags'),
            'body' => \Yii::t('common', 'Body'),
            'view' => \Yii::t('common', 'Article View'),
            'category_id' => \Yii::t('common', 'Category'),
            'thumbnail_base_url' => \Yii::t('common', 'Thumbnail'),
            'thumbnail_path' => \Yii::t('common', 'Thumbnail Path'),
            'status' => \Yii::t('common', 'Published'),
            'published_at' => \Yii::t('common', 'Published At'),
            'is_pinned' => \Yii::t('common', 'Pinned'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    public function setAttributes($values, $safeOnly = true): void
    {
        if (is_array($values)) {
            if (array_key_exists('thumbnail', $values)
                && ('' === $values['thumbnail'] || null === $values['thumbnail'])) {
                $values['thumbnail'] = null;
            }

            if (array_key_exists('attachments', $values)
                && ('' === $values['attachments'] || null === $values['attachments'])) {
                $values['attachments'] = [];
            }

            if (array_key_exists('published_at', $values)) {
                $values['published_at'] = $this->normalizeDateTimeInput($values['published_at']);
            }
        }

        parent::setAttributes($values, $safeOnly);
    }

    public function afterFind(): void
    {
        parent::afterFind();

        $this->tagTitles = array_values(array_unique(array_filter(array_map(
            static fn (Tag $tag): string => trim((string) $tag->title),
            $this->tags
        ))));
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $this->syncTagRelations();
    }

    public function getUpdater(): ActiveQuery
    {
        return $this->getUpdatedBy();
    }

    /**
     * @return ArticleQuery the active query used by this AR class
     */
    public static function find(): ArticleQuery
    {
        $query = new ArticleQuery(get_called_class());

        return $query->where(['t_article.is_deleted' => 0]);
    }

    public function getTagKeywordString(): string
    {
        return implode(', ', $this->tagTitles);
    }

    /**
     * Normalizes datetime input coming from HTML datetime-local fields.
     */
    private function normalizeDateTimeInput(?string $value): ?string
    {
        if (null === $value || '' === $value) {
            return $value;
        }

        $normalized = str_replace('T', ' ', trim($value));
        if (1 === preg_match('/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/', $normalized)) {
            $normalized .= ':00';
        }

        return $normalized;
    }

    private function syncTagRelations(): void
    {
        $titles = [];
        foreach ($this->tagTitles as $tagTitle) {
            $normalized = trim((string) $tagTitle);
            if ('' !== $normalized) {
                $titles[$normalized] = $normalized;
            }
        }

        $titles = array_values($titles);
        $db = static::getDb();

        $db->createCommand()->delete('{{%article_tag}}', ['article_id' => $this->id])->execute();

        if ([] === $titles) {
            return;
        }

        $existingTags = Tag::find()->where(['title' => $titles])->indexBy('title')->all();
        $tagIds = [];

        foreach ($titles as $title) {
            if (!isset($existingTags[$title])) {
                $tag = new Tag(['title' => $title]);
                if (!$tag->save()) {
                    continue;
                }

                $existingTags[$title] = $tag;
            }

            $tagIds[] = (int) $existingTags[$title]->id;
        }

        $tagIds = array_values(array_unique($tagIds));
        if ([] === $tagIds) {
            return;
        }

        $rows = array_map(fn (int $tagId): array => [$this->id, $tagId], $tagIds);
        $db->createCommand()
            ->batchInsert('{{%article_tag}}', ['article_id', 'tag_id'], $rows)
            ->execute()
        ;

        // Keep in-memory relation and helper output consistent after save.
        $this->populateRelation('tags', array_values($existingTags));
        $this->tagTitles = $titles;
    }
}
