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

    public static function getOneFontAwesomeBrands($_module = null): string
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

    public static function getHome(): string
    {
        return '<i class="fas fa-home"></i>';
    }
    public static function getGithub(): string
    {
        return '<i class="fab fa-github"></i>';
    }
    public static function getSave(): string
    {
        return '<i class="fas fa-save"></i>';
    }
    public static function getSignIn(): string
    {
        return '<i class="fas fa-sign-in-alt"></i>';
    }
    public static function getChartLine(): string
    {
        return '<i class="fas fa-chart-line"></i>';
    }
    public static function getView(): string
    {
        return '<i class="fas fa-eye"></i>';
    }
    public static function getUpdate(): string
    {
        return '<i class="fas fa-pencil-alt"></i>';
    }
    public static function getUser(): string
    {
        return '<i class="fas fa-user"></i>';
    }

    public static function getReset(): string
    {
        return '<i class="fas fa-sync"></i>';
    }
    public static function getImport(): string
    {
        return '<i class="fas fa-file-import"></i>';
    }
    public static function getAdd(): string
    {
        return '<i class="fas fa-plus"></i>';
    }

    public static function getPin(): string
    {
        return '<i class="fas fa-thumbtack"></i>';
    }

    public static function getPrint(): string
    {
        return '<i class="fas fa-print"></i>';
    }

    public static function getPlus(): string
    {
        return '<i class="fas fa-plus"></i>';
    }

    public static function getDelete(): string
    {
        return '<i class="fas fa-trash-alt"></i>';
    }
    public static function getMinus(): string
    {
        return '<i class="fas fa-minus"></i>';
    }
    public static function getUpload(): string
    {
        return '<i class="fas fa-file-upload"></i>';
    }
}