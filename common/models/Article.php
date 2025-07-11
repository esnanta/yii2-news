<?php

namespace common\models;

use common\helper\ContentHelper;
use common\helper\LabelHelper;
use common\models\base\Article as BaseArticle;
use yii\db\ActiveQuery;
use yii\helpers\Html;

class Article extends BaseArticle
{
    public const PUBLISH_STATUS_NO = 1;
    public const PUBLISH_STATUS_YES = 2;

    public const PINNED_STATUS_NO = 1;
    public const PINNED_STATUS_YES = 2;
    public static $path = '/images';
    private $_oldTags;

    public function rules(): array
    {
        return [
            [['tags'], 'safe'],
            [['content'], 'validateImageSize'],

            [['office_id', 'article_category_id', 'author_id', 'publish_status', 'pinned_status',
                'view_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'],
                'integer'],
            [['content', 'description'], 'string'],
            [['rating'], 'number'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['cover', 'url'], 'string', 'max' => 300],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'office_id' => \Yii::t('app', 'Office'),
            'article_category_id' => \Yii::t('app', 'Category'),
            'author_id' => \Yii::t('app', 'Author'),
            'title' => \Yii::t('app', 'Title'),
            'cover' => \Yii::t('app', 'Cover'),
            'url' => \Yii::t('app', 'Url'),
            'content' => \Yii::t('app', 'Content'),
            'description' => \Yii::t('app', 'Description'),
            'tags' => \Yii::t('app', 'Tags'),
            'publish_status' => \Yii::t('app', 'Publish'),
            'pinned_status' => \Yii::t('app', 'Pinned'),
            'view_counter' => \Yii::t('app', 'Counter'),
            'rating' => \Yii::t('app', 'Rating'),
            'date_issued' => \Yii::t('app', 'Issued'),
            'is_deleted' => \Yii::t('app', 'Is Deleted'),
            'verlock' => \Yii::t('app', 'Verlock'),
            'uuid' => \Yii::t('app', 'Uuid'),
        ];
    }

    /**
     * Custom validator for image size in content.
     *
     * @param mixed $attribute
     * @param mixed $params
     * @param mixed $validator
     */
    public function validateImageSize($attribute, $params, $validator): void
    {
        $validationResult = ContentHelper::validateImageSize($this->{$attribute});
        if (true !== $validationResult) {
            $this->addError($attribute, $validationResult);
        }
    }

    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord) {
            $this->view_counter = 0;
            $this->publish_status = self::PUBLISH_STATUS_NO;
            $this->pinned_status = self::PINNED_STATUS_NO;
        }

        if (empty($this->date_issued)) {
            $this->date_issued = $this->created_at;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        // add your code here
        Tag::updateFrequency($this->_oldTags, $this->tags);
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        // add your code here
        Tag::updateFrequencyOnDelete($this->_oldTags);
    }

    /**
     * This is invoked when a record is populated with data from a find() call.
     */
    public function afterFind(): void
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster.
     *
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'author',
            'articleCategory',
            'office',
            'user', // ADD
        ];
    }

    public static function getArrayPublishStatus(): array
    {
        return [
            // MASTER
            self::PUBLISH_STATUS_NO => \Yii::t('app', 'Draft'),
            self::PUBLISH_STATUS_YES => \Yii::t('app', 'Published'),
        ];
    }

    public static function getOnePublishStatus($_module = null): string
    {
        if ($_module) {
            $arrayModule = self::getArrayPublishStatus();

            switch ($_module) {
                case self::PUBLISH_STATUS_NO == $_module:
                    $returnValue = LabelHelper::getNo($arrayModule[$_module]);

                    break;

                case self::PUBLISH_STATUS_YES == $_module:
                    $returnValue = LabelHelper::getYes($arrayModule[$_module]);

                    break;

                default:
                    $returnValue = LabelHelper::getDefault();
            }

            return $returnValue;
        }

        return 'null';
    }

    public static function getArrayPinnedStatus(): array
    {
        return [
            // MASTER
            self::PINNED_STATUS_NO => \Yii::t('app', 'No'),
            self::PINNED_STATUS_YES => \Yii::t('app', 'Yes'),
        ];
    }

    public static function getOnePinnedStatus($_module = null): string
    {
        if ($_module) {
            $arrayModule = self::getArrayPinnedStatus();

            switch ($_module) {
                case self::PINNED_STATUS_NO == $_module:
                    $returnValue = LabelHelper::getNo($arrayModule[$_module]);

                    break;

                case self::PINNED_STATUS_YES == $_module:
                    $returnValue = LabelHelper::getYes($arrayModule[$_module]);

                    break;

                default:
                    $returnValue = LabelHelper::getDefault();
            }

            return $returnValue;
        }

        return 'null';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUrl(): string
    {
        return \Yii::$app->getUrlManager()->createUrl(['article/view', 'id' => $this->id, 'title' => $this->title]);
    }

    public function getPublishUrl(): string
    {
        $value = (self::PUBLISH_STATUS_NO == $this->publish_status)
            ? LabelHelper::getNo(LabelHelper::getPrintIcon())
            : LabelHelper::getYes(LabelHelper::getPrintIcon());

        return Html::a($value, \Yii::$app->getUrlManager()->createUrl(['article/publish', 'id' => $this->id]));
    }

    public function getPinUrl(): string
    {
        $value = (self::PINNED_STATUS_NO == $this->pinned_status)
            ? LabelHelper::getNo(LabelHelper::getPinIcon())
            : LabelHelper::getYes(LabelHelper::getPinIcon());

        return Html::a($value, \Yii::$app->getUrlManager()->createUrl(['article/pinned', 'id' => $this->id]));
    }

    /**
     * fetch stored image url.
     */
    public function getDefaultAuthorImage(): string
    {
        return $this->author->getAssetUrl();
    }

    /**
     * Process deletion of image.
     *
     * @return bool the status of deletion
     */
    public function deleteImage()
    {
        $fileDirectory = str_replace('frontend', 'backend', \Yii::getAlias('@webroot')).'/uploads/article';

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content);
        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query('//img') as $node) {
            $poolNode = $node->getAttribute('src');
            if (str_contains($poolNode, 'article/')) {
                $image = substr($poolNode, strpos($poolNode, 'article/'));

                $file = $fileDirectory.str_replace('article', '', $image);
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    public static function countByMonthPeriod($year, $month)
    {
        $monthPeriod = (strlen($month) > 1) ? $month : '0'.$month;

        $query = Article::find()->where(['month_period' => $monthPeriod.$year]);

        $queryCount = $query->asArray()->count();

        return (!empty($queryCount)) ? $queryCount : 0;
    }

    public static function getCounterByMonthPeriod($year, $month)
    {
        $monthPeriod = (strlen($month) > 1) ? $month : '0'.$month;

        $query = Article::find()->where(['month_period' => $monthPeriod.$year]);

        $queryCount = $query->sum('view_counter');

        return (!empty($queryCount)) ? $queryCount : 0;
    }
}
