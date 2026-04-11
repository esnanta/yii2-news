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
 * This is the model class for table "article".
 *
 * @property int                 $id
 * @property string              $slug
 * @property string              $title
 * @property string              $body
 * @property string              $view
 * @property string              $thumbnail_base_url
 * @property string              $thumbnail_path
 * @property array               $attachments
 * @property int                 $category_id
 * @property int                 $status
 * @property string              $published_at
 * @property int                 $created_by
 * @property int                 $updated_by
 * @property string              $created_at
 * @property string              $updated_at
 * @property User                $author
 * @property User                $updater
 * @property ArticleCategory     $category
 * @property ArticleAttachment[] $articleAttachments
 */
class Article extends BaseArticle
{
    public const STATUS_PUBLISHED = 1;
    public const STATUS_DRAFT = 0;

    public array $attachments = [];

    public ?array $thumbnail = null;

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
            [['author_id', 'category_id', 'status',
                'created_by', 'updated_by', 'is_deleted',
                'deleted_by', 'verlock'], 'integer'],
            [['slug', 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['published_at'], 'date', 'format' => 'php:Y-m-d'],
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
            'body' => \Yii::t('common', 'Body'),
            'view' => \Yii::t('common', 'Article View'),
            'category_id' => \Yii::t('common', 'Category'),
            'thumbnail_base_url' => \Yii::t('common', 'Thumbnail'),
            'thumbnail_path' => \Yii::t('common', 'Thumbnail Path'),
            'status' => \Yii::t('common', 'Status'),
            'published_at' => \Yii::t('common', 'Published At'),
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
        }

        parent::setAttributes($values, $safeOnly);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdater()
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
}
