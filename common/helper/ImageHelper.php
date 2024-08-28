<?php
namespace common\helper;

use Yii;

class ImageHelper {
    public static function getNotAvailable(): string
    {
        return Yii::$app->urlManager->baseUrl.'/images/no-picture-available-icon-1.jpg';
    }
    public static function getLogin(): string
    {
        return Yii::$app->urlManager->baseUrl.'/images/if_skype2512x512_197582.png';
    }
}