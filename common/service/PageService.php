<?php

namespace common\service;

use common\helper\ContentHelper;
use common\models\Page;
use yii\db\ActiveRecord;

class PageService
{
    public static function getLogo1($width='100px',$height='40px') : string
    {
        $model = Page::find(['content'])->where(['id'=>1])->one();
        return ContentHelper::getLogo($model->content,$width,$height);
    }

    public static function getLogo2($width='100px',$height='40px') : string
    {
        $model = Page::find(['content'])->where(['id'=>2])->one();
        return ContentHelper::getLogo($model->content,$width,$height);
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
}