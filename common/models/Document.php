<?php

namespace common\models;

use common\models\base\Document as BaseDocument;
use common\models\query\DocumentQuery;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "t_document".
 */
class Document extends BaseDocument
{
    public const FLAG_NO = 2;
    public const FLAG_YES = 1;
    private const ALLOWED_UPLOAD_EXTENSIONS = ['pdf', 'docx', 'xlsx'];

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
            self::FLAG_NO => \Yii::t('common', 'No'),
            self::FLAG_YES => \Yii::t('common', 'Yes'),
        ];
    }

    public static function allowedUploadExtensions(): array
    {
        return self::ALLOWED_UPLOAD_EXTENSIONS;
    }

    public static function uploadAcceptFileTypesRegex(): string
    {
        $extensions = implode('|', self::allowedUploadExtensions());

        return '/(\\.|\\/)('.$extensions.')$/i';
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
                [['documentFile'], 'validateDocumentFileType'],
                [['office_id', 'is_visible', 'category_id', 'size', 'view_count', 'download_count',
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
}
