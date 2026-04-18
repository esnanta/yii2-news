<?php

use common\models\Document;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View     $this
 * @var Document $model
 */
$documentTypes = Document::documentTypeOptions();
$documentTypeName = $documentTypes[$model->document_type] ?? Yii::t('common', 'Unknown');

?>

<div class="card border-default mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <?php echo Html::a(Html::encode($model->title), ['document/view', 'id' => $model->id]); ?>
        </h5>
        <span class="text-muted small">
            <?php echo FAS::icon('download'); ?>
            <?php echo (int) $model->download_count; ?>
        </span>
    </div>
    <div class="card-body">
        <?php if (!empty($model->description)) { ?>
            <p class="card-text"><?php echo nl2br(Html::encode($model->description)); ?></p>
        <?php } ?>
    </div>
    <div class="card-footer text-muted">
        <div class="row align-items-center">
            <div class="col-md-8">
                <ul class="list-unstyled d-flex flex-wrap mb-0">
                    <li class="mr-4 d-flex align-items-center">
                        <i class="fa fa-calendar mr-2"></i>
                        <?php echo Yii::$app->formatter->asDate($model->created_at); ?>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fa fa-file mr-2"></i>
                        <?php echo Html::encode($documentTypeName); ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 text-right">
                <?php echo Html::a(
                    FAS::icon('download').' '
                        .Yii::t('common', 'Download'),
                    ['document/download', 'id' => $model->id],
                    [
                        'class' => 'btn btn-primary btn-sm',
                        'data-pjax' => '0', // Mencegah pjax mengganggu unduhan
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>
