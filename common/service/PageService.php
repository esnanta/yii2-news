<?php

namespace common\service;

use common\helper\ContentHelper;
use common\models\Page;
use yii\db\ActiveRecord;

class PageService
{
    private static function getLogo1() : string
    {
        $model = Page::find(['content'])->where(['id'=>1])->one();
        return $model->content;
    }

    private static function getLogo2() : string
    {
        $model = Page::find(['content'])->where(['id'=>2])->one();
        return $model->content;
    }

    private static function getLogoReport1() : string {
        $model = Page::find(['content'])->where(['id'=>3])->one();
        return $model->content;
    }

    private static function getLogoReport2() : string {
        $model = Page::find(['content'])->where(['id'=>4])->one();
        return $model->content;
    }

    public static function getDescription() : string {
        $model = Page::find(['content'])->where(['id'=>11])->one();
        return empty($model->content) ? '' : strip_tags($model->content);
    }

    public static function getKeyWord() : string {
        $model = Page::find(['content'])->where(['id'=>12])->one();
        return empty($model->content) ? '' : strip_tags($model->content);
    }

    public static function getAbout(): array|ActiveRecord|null
    {
        return Page::find()->where(['id'=>21])->one();
    }

    public static function getLogo1Url() : string {
        return ContentHelper::getLogo(self::getLogo1());
    }

    public static function getLogo2Url() : string {
        return ContentHelper::getLogo(self::getLogo2());
    }
}