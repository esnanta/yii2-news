<?php

namespace common\models;

use common\models\base\Document as BaseDocument;
use common\models\query\DocumentQuery;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "t_document".
 *
 * @property null|string $storageFilePath
 * @property null|string $url
 */
class Document extends BaseDocument
{
    public const FLAG_NO = 2;
    public const FLAG_YES = 1;

    public const TYPE_IMAGE = 1;
    public const TYPE_OFFICE_DOCUMENT = 2;
    public const TYPE_PDF = 3;

    private const IMAGE_UPLOAD_EXTENSIONS = ['jpg', 'jpeg', 'png'];
    private const OFFICE_DOCUMENT_UPLOAD_EXTENSIONS = ['doc', 'docx', 'xlsx'];
    private const PDF_UPLOAD_EXTENSIONS = ['pdf'];
    private const UPLOAD_EXTENSIONS_BY_TYPE = [
        self::TYPE_IMAGE => self::IMAGE_UPLOAD_EXTENSIONS,
        self::TYPE_OFFICE_DOCUMENT => self::OFFICE_DOCUMENT_UPLOAD_EXTENSIONS,
        self::TYPE_PDF => self::PDF_UPLOAD_EXTENSIONS,
    ];

    /**
     * Virtual attribute used by filekit upload widget.
     */
    public array|string|null $documentFile = null;

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'documentUpload' => [
                'class' => UploadBehavior::class,
                'attribute' => 'documentFile',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
        ]);
    }

    /**
     * @return array options for is_visible dropdown
     */
    public static function visibleOptions(): array
    {
        return [
            self::FLAG_NO => \Yii::t('common', 'Private'),
            self::FLAG_YES => \Yii::t('common', 'Public'),
        ];
    }

    /**
     * @return array options for document_type dropdown
     */
    public static function documentTypeOptions(): array
    {
        return [
            self::TYPE_IMAGE => \Yii::t('common', 'Image'),
            self::TYPE_OFFICE_DOCUMENT => \Yii::t('common', 'Office Document'),
            self::TYPE_PDF => \Yii::t('common', 'PDF'),
        ];
    }

    public static function allowedUploadExtensionsByType(?int $documentType): array
    {
        if (null === $documentType) {
            return [];
        }

        return self::UPLOAD_EXTENSIONS_BY_TYPE[$documentType] ?? [];
    }

    public static function allowedUploadExtensions(): array
    {
        $extensions = [];

        foreach (self::UPLOAD_EXTENSIONS_BY_TYPE as $typeExtensions) {
            $extensions = array_merge($extensions, $typeExtensions);
        }

        return array_values(array_unique($extensions));
    }

    public static function uploadAcceptFileTypesRegex(): string
    {
        $extensions = implode('|', self::allowedUploadExtensions());

        return '/(\.|\/)('.$extensions.')$/i';
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['documentFile'], 'safe'],
                [['documentFile'], 'required', 'when' => static function (self $model): bool {
                    return $model->isNewRecord && empty($model->path);
                }],
                [['title'], 'required'],
                [['documentFile'], 'validateDocumentFileType'],
                [['office_id', 'is_visible', 'category_id', 'document_type', 'size', 'view_count', 'download_count',
                    'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['description'], 'string'],
                [['title'], 'string', 'max' => 200],
                [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'office_id' => \Yii::t('common', 'Office'),
            'is_visible' => \Yii::t('common', 'Is Visible'),
            'category_id' => \Yii::t('common', 'Category'),
            'document_type' => \Yii::t('common', 'Document Type'),
            'title' => \Yii::t('common', 'Title'),
            'date_issued' => \Yii::t('common', 'Date Issued'),
            'base_url' => \Yii::t('common', 'Base Url'),
            'path' => \Yii::t('common', 'Path'),
            'name' => \Yii::t('common', 'Name'),
            'type' => \Yii::t('common', 'Type'),
            'size' => \Yii::t('common', 'Size'),
            'view_count' => \Yii::t('common', 'View Count'),
            'download_count' => \Yii::t('common', 'Download Count'),
            'description' => \Yii::t('common', 'Description'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    /**
     * @return DocumentQuery the active query used by this AR class
     */
    public static function find(): DocumentQuery
    {
        $query = new DocumentQuery(get_called_class());

        return $query->where(['t_document.is_deleted' => 0]);
    }

    public function validateDocumentFileType(string $attribute): void
    {
        $fileName = null;
        $fileData = $this->{$attribute};
        if (is_array($fileData)) {
            $fileName = $fileData['name'] ?? null;
        } elseif (is_string($fileData)) {
            $fileName = $fileData;
        }

        if (!is_string($fileName) || '' === trim($fileName)) {
            return;
        }

        $extension = strtolower((string) pathinfo($fileName, PATHINFO_EXTENSION));
        if ('' === $extension) {
            return;
        }

        if (!in_array($extension, self::allowedUploadExtensions(), true)) {
            $this->addError(
                $attribute,
                \Yii::t('common', 'Document must be a file of type: {types}.', [
                    'types' => strtoupper(implode(', ', self::allowedUploadExtensions())),
                ])
            );

            return;
        }

        $allowedExtensionsByType = self::allowedUploadExtensionsByType(
            is_numeric($this->document_type) ? (int) $this->document_type : null
        );

        if ([] !== $allowedExtensionsByType && !in_array($extension, $allowedExtensionsByType, true)) {
            $this->addError(
                $attribute,
                \Yii::t('common', 'Selected document type only allows: {types}.', [
                    'types' => strtoupper(implode(', ', $allowedExtensionsByType)),
                ])
            );
        }
    }

    public function getStorageFilePath(): ?string
    {
        if (empty($this->path)) {
            return null;
        }

        $relativePath = ltrim((string) $this->path, '/');
        $candidates = [
            \Yii::getAlias('@storage/web/source/'.$relativePath),
            \Yii::getAlias('@storage/web/'.$relativePath),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    public function getUrl(): string
    {
        return $this->base_url.'/'.$this->path;
    }
}
