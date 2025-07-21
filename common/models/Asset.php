<?php

namespace common\models;

use common\helper\LabelHelper;
use common\models\base\Asset as BaseAsset;
use common\service\AssetService;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "tx_asset".
 *
 * @property null|mixed $file_name
 */
class Asset extends BaseAsset
{
    public const IS_VISIBLE_PRIVATE = 1;
    public const IS_VISIBLE_PUBLIC = 2;

    public const ASSET_TYPE_WORD = 1;
    public const ASSET_TYPE_SPREADSHEET = 2;
    public const ASSET_TYPE_IMAGE = 3;
    public const ASSET_TYPE_COMPRESSION = 4;
    public const ASSET_TYPE_PDF = 5;
    public $asset;

    public $file;
    public $url;

    public function rules(): array
    {
        return [
            // TAMBAHAN
            [['is_visible', 'asset_category_id'], 'required'],
            [['asset'], 'file', 'maxSize' => (1024 * 1024 * 20), 'tooBig' => 'Limit is 20MB'],

            [['office_id', 'is_visible', 'asset_type', 'asset_category_id', 'size',
                'view_counter', 'download_counter', 'created_by', 'updated_by',
                'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['description'], 'string'],
            [['title', 'asset_name'], 'string', 'max' => 200],
            [['asset_url'], 'string', 'max' => 500],
            [['mime_type'], 'string', 'max' => 100],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'office_id' => \Yii::t('app', 'Office'),
            'is_visible' => \Yii::t('app', 'Is Visible'),
            'asset_type' => \Yii::t('app', 'Type'),
            'asset_group' => \Yii::t('app', 'Group'),
            'asset_category_id' => \Yii::t('app', 'Category'),
            'title' => \Yii::t('app', 'Title'),
            'date_issued' => \Yii::t('app', 'Issued'),
            'asset_name' => \Yii::t('app', 'Name'),
            'asset_url' => \Yii::t('app', 'Url'),
            'size' => \Yii::t('app', 'Size'),
            'mime_type' => \Yii::t('app', 'Mime Type'),
            'view_counter' => \Yii::t('app', 'Counter'),
            'download_counter' => \Yii::t('app', 'Download'),
            'description' => \Yii::t('app', 'Description'),
            'is_deleted' => \Yii::t('app', 'Is Deleted'),
            'verlock' => \Yii::t('app', 'Verlock'),
            'uuid' => \Yii::t('app', 'Uuid'),
        ];
    }

    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord) {
            $this->download_counter = 0;
            $this->view_counter = 0;
        }

        return parent::beforeSave($insert);
    }

    public static function getArrayIsVisible(): array
    {
        return [
            // MASTER
            self::IS_VISIBLE_PRIVATE => \Yii::t('app', 'Private'),
            self::IS_VISIBLE_PUBLIC => \Yii::t('app', 'Public'),
        ];
    }

    public static function getOneIsVisible($_module = null): string
    {
        if ($_module) {
            $arrayModule = self::getArrayIsVisible();

            switch ($_module) {
                case self::IS_VISIBLE_PRIVATE == $_module:
                    $returnValue = LabelHelper::getNo($arrayModule[$_module]);

                    break;

                case self::IS_VISIBLE_PUBLIC == $_module:
                    $returnValue = LabelHelper::getYes($arrayModule[$_module]);

                    break;

                default:
                    $returnValue = LabelHelper::getDefault($arrayModule[$_module]);
            }

            return $returnValue;
        }

        return '-';
    }

    public static function getArrayAssetType(): array
    {
        return [
            // MASTER
            self::ASSET_TYPE_WORD => \Yii::t('app', 'Word'),
            self::ASSET_TYPE_SPREADSHEET => \Yii::t('app', 'Spreadsheet'),
            self::ASSET_TYPE_IMAGE => \Yii::t('app', 'Image'),
            self::ASSET_TYPE_COMPRESSION => \Yii::t('app', 'Compression'),
            self::ASSET_TYPE_PDF => \Yii::t('app', 'Pdf'),
        ];
    }

    public static function getOneAssetType($_module = null)
    {
        if ($_module) {
            $arrayModule = self::getArrayAssetType();

            switch ($_module) {
                case self::ASSET_TYPE_WORD == $_module:
                    $returnValue = LabelHelper::getPrimary($arrayModule[$_module]);

                    break;

                case self::ASSET_TYPE_SPREADSHEET == $_module:
                    $returnValue = LabelHelper::getSuccess($arrayModule[$_module]);

                    break;

                case self::ASSET_TYPE_IMAGE == $_module:
                    $returnValue = LabelHelper::getSecondary($arrayModule[$_module]);

                    break;

                case self::ASSET_TYPE_COMPRESSION == $_module:
                    $returnValue = LabelHelper::getDanger($arrayModule[$_module]);

                    break;

                case self::ASSET_TYPE_PDF == $_module:
                    $returnValue = LabelHelper::getInfo($arrayModule[$_module]);

                    break;

                default:
                    $returnValue = LabelHelper::getDefault($arrayModule[$_module]);
            }

            return $returnValue;
        }

        return '-';
    }

    // Public static method to return the file types array
    public static function getArrayFileExtension(): array
    {
        return [
            self::ASSET_TYPE_SPREADSHEET => ['xlsx', 'xls'],
            self::ASSET_TYPE_IMAGE => ['jpg', 'jpeg', 'png', 'gif'],
            self::ASSET_TYPE_WORD => ['doc', 'docx'],
            self::ASSET_TYPE_COMPRESSION => ['zip', 'rar'],
            self::ASSET_TYPE_PDF => ['pdf'],
        ];
    }

    /**
     * fetch stored asset file name with complete path.
     *
     * @throws Exception
     */
    public function getAssetFile(): ?string
    {
        return (new AssetService())->getAssetFile($this);
    }

    /**
     * Generates a URL pointing to a file on the server (image, PDF, etc.).
     * fetch stored asset url.
     */
    public function getAssetUrl(): string
    {
        return (new AssetService())->getAssetUrl($this);
    }

    /**
     * Generates a URL pointing to a Yii controller action for routing requests.
     */
    public function getUrl(): string
    {
        return \Yii::$app->getUrlManager()->createUrl(['asset/view', 'id' => $this->id,
            'title' => $this->title]);
    }

    public function downloadFile($path): void
    {
        if (!empty($path)) {
            // header("Content-type:application/pdf"); //for pdf file

            header('Content-Type:text/plain; charset=ISO-8859-15');
            // if you want to read text file using text/plain header
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Content-Length: '.filesize($path));
            readfile($path);

            $this->download_counter = $this->download_counter + 1;
            $this->save();

            \Yii::app()->end();
        }
    }
}
