<?php

namespace common\service;

use common\models\ArticleCategory;
use common\models\Author;
use common\models\DocumentCategory;
use common\models\Employment;
use common\models\Office;
use common\models\Page;
use common\models\SocialPlatform;
use common\models\Staff;
use yii\helpers\ArrayHelper;

class DataListService
{
    public static function getOffice(): array
    {
        return ArrayHelper::map(Office::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getAuthor(): array
    {
        return ArrayHelper::map(Author::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getSocialPlatform(): array
    {
        return ArrayHelper::map(SocialPlatform::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getDocumentCategory(): array
    {
        return ArrayHelper::map(DocumentCategory::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getEmployment(): array
    {
        return ArrayHelper::map(Employment::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getStaff(): array
    {
        return ArrayHelper::map(Staff::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getPage(): array
    {
        return ArrayHelper::map(Page::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getArticleCategory(): array
    {
        return ArrayHelper::map(ArticleCategory::find()
            ->asArray()->all(), 'id', 'title');
    }
}
