<?php

namespace common\service;

use common\helper\DataIdHelper;
use common\models\ArticleCategory;
use common\models\Asset;
use common\models\AssetCategory;
use common\models\Author;
use common\models\Employment;
use common\models\Office;
use common\models\Page;
use common\models\Staff;
use yii\helpers\ArrayHelper;

class DataListService
{
    public static function getOffice(): array
    {
        return ArrayHelper::map(Office::find()
            ->where(['id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }

    public static function getEmployment(): array
    {
        return ArrayHelper::map(Employment::find()
            ->where(['office_id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }

    public static function getAsset(): array
    {
        return ArrayHelper::map(Asset::find()
            ->where(['office_id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }

    public static function getAssetCategory(): array
    {
        return ArrayHelper::map(AssetCategory::find()
            ->where(['office_id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }
    public static function getArticleCategory(): array
    {
        return ArrayHelper::map(ArticleCategory::find()
            ->where(['office_id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }
    public static function getAuthor(): array
    {
        return ArrayHelper::map(Author::find()
            ->where(['office_id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }

    public static function getStaff(): array
    {
        return ArrayHelper::map(Staff::find()
            ->where(['office_id' => DataIdHelper::getOfficeId()])
            ->asArray()->all(), 'id', 'title');
    }

    public static function getPage(): array
    {
        return ArrayHelper::map(Page::find()
            ->asArray()->all(), 'id', 'title');
    }
}