<?php

namespace common\helper;

use Yii;

class MediaTypeHelper
{
    public static function getLogoLeft(): int
    {
        return 1;
    }
    public static function getLogoRight(): int
    {
        return 2;
    }
    public static function getSocial(): int
    {
        return 11;
    }
    public static function getLink(): int
    {
        return 12;
    }

    public static function getArrayMediaType(): array
    {
        return [
            //MASTER
            self::getLogoLeft()    => Yii::t('app', 'Left Logo') ,
            self::getLogoRight()   => Yii::t('app', 'Right Logo'),
            self::getSocial()      => Yii::t('app', 'Social'),
            self::getLink()        => Yii::t('app', 'Link'),
        ];
    }

    public static function getOneMediaType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayMediaType();

            switch ($_module) {
                case ($_module == self::getLogoLeft()):
                    $returnValue = LabelHelper::getPrimary($arrayModule[$_module]);
                    break;
                case ($_module == self::getLogoRight()):
                    $returnValue = LabelHelper::getSuccess($arrayModule[$_module]);
                    break;
                case ($_module == self::getSocial()):
                    $returnValue = LabelHelper::getDanger($arrayModule[$_module]);
                    break;
                case ($_module == self::getLink()):
                    $returnValue = LabelHelper::getWarning($arrayModule[$_module]);
                    break;
                default:
                    $returnValue = LabelHelper::getDefault($arrayModule[$_module]);
            }

            return $returnValue;
        }
        else
            return '-';
    }
}