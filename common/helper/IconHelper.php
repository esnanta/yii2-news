<?php

namespace common\helper;

class IconHelper
{
    const INSTAGRAM = 'fab fa-instagram';
    const TWITTER = 'fab fa-twitter';
    const FACEBOOK = 'fab fa-facebook';
    const TIKTOK = 'fab fa-tiktok';
    const LINKEDIN = 'fab fa-linkedin';
    const GITHUB = 'fab fa-github';
    const GOOGLE = 'fab fa-google';
    const YOUTUBE = 'fab fa-youtube';

    public static function getFontAwesomeBrands(): array
    {
        return [
            self::INSTAGRAM => 'Instagram',
            self::TWITTER => 'Twitter',
            self::FACEBOOK => 'Facebook',
            self::TIKTOK => 'Tiktok',
            self::LINKEDIN => 'Linkedin',
            self::GITHUB => 'Github',
            self::GOOGLE => 'Google',
            self::YOUTUBE => 'youtube',
        ];
    }

    public static function getOneFontAwesome($_module = null): string
    {
        if($_module)
        {
            $arrayModule = self::getFontAwesomeBrands();
            switch ($_module) {
                case ($_module == self::INSTAGRAM):
                case ($_module == self::TWITTER):
                case ($_module == self::FACEBOOK):
                case ($_module == self::LINKEDIN):
                case ($_module == self::GITHUB):
                case ($_module == self::TIKTOK):
                case ($_module == self::GOOGLE):
                case ($_module == self::YOUTUBE):
                    $returnValue = $arrayModule[$_module];
                    break;
                default:
                    $returnValue = '';
            }
            return $returnValue;
        }
        else
            return '-';
    }

    public static function getFontAwesomeBrandValue(string $iconClass): string
    {
        $brands = self::getFontAwesomeBrands();

        return $brands[$iconClass] ?? 'Unknown';
    }
}