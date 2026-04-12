<?php

namespace common\helper;

use common\service\LayoutService;
use Yii;

class MetaHelper
{
    public static function setMetaTags(): void
    {
        // $description    = LayoutService::getDescription();
        // $keyword        = LayoutService::getKeyWord();
        // $logo1Image     = LayoutService::getLogo1();

        // Yii::$app->params['meta_description']['content'] = $description;
        // Yii::$app->params['meta_keywords']['content'] = $keyword;
        // Yii::$app->params['og_site_name']['content'] = Yii::$app->name;

        \Yii::$app->params['og_image']['content'] = $logo1Image;
        \Yii::$app->params['twitter_image']['content'] = $logo1Image;
        \Yii::$app->params['googleplus_image']['content'] = $logo1Image;
    }
}
