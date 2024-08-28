<?php

namespace common\models;


use common\helper\ContentHelper;
use common\helper\LabelHelper;
use common\models\base\Page as BaseThemeDetail;
use Yii;

class Page extends BaseThemeDetail
{
    const PAGE_TYPE_TEXT     = 1;
    const PAGE_TYPE_IMAGE    = 2;

    /**
     * @inheritdoc
     */ 
    public function rules(): array
    {
        return [
            //TAMBAHAN
            [['content'], 'validateImageSize'],

            [['page_type', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['content', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * Custom validator for image size in content
     */
    public function validateImageSize($attribute, $params, $validator): void
    {
        $validationResult = ContentHelper::validateImageSize($this->$attribute);
        if ($validationResult !== true) {
            $this->addError($attribute, $validationResult);
        }
    }

    public static function getArrayPageType(): array
    {
        return [
            //MASTER
            self::PAGE_TYPE_TEXT    => Yii::t('app', 'Text'),
            self::PAGE_TYPE_IMAGE   => Yii::t('app', 'Image'),
        ];
    }

    public static function getOnePageType($_module = null): string
    {
        if($_module)
        {
            $arrayModule = self::getArrayPageType();
            switch ($_module) {
                case ($_module == self::PAGE_TYPE_TEXT):
                    $returnValue = LabelHelper::getPrimary($arrayModule[$_module]);
                    break;
                case ($_module == self::PAGE_TYPE_IMAGE):
                    $returnValue = LabelHelper::getSuccess($arrayModule[$_module]);
                    break;
                default:
                    $returnValue = LabelHelper::getDefault();
            }
            return $returnValue;
        }
        else
            return 'null';
    }
}
