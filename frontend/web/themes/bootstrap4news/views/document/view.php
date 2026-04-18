<?php

use common\models\Document;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$documentUrl = $model->getUrl();
?>

<div class="document-view">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title h2"><?php echo Html::encode($this->title); ?></h1>
        </div>
        <div class="card-body">
            <?php if (!empty($model->description)) { ?>
                <p class="card-text"><?php echo nl2br(Html::encode($model->description)); ?></p>
            <?php } ?>

            <?php
            switch ($model->document_type) {
                case Document::TYPE_IMAGE:
                    echo Html::img($documentUrl, ['class' => 'img-fluid', 'alt' => $model->title]);

                    break;

                case Document::TYPE_PDF:
                    echo Html::tag('iframe', '', [
                        'src' => $documentUrl,
                        'width' => '100%',
                        'height' => '800px',
                        'style' => 'border: none;',
                    ]);

                    break;

                case Document::TYPE_OFFICE_DOCUMENT:
                    // Gunakan Microsoft Office Online Viewer untuk menyematkan dokumen office
                    $officeViewerUrl = 'https://view.officeapps.live.com/op/embed.aspx?src='.urlencode($documentUrl);
                    echo Html::tag('iframe', 'Your browser does not support iframes.', [
                        'src' => $officeViewerUrl,
                        'width' => '100%',
                        'height' => '800px',
                        'frameborder' => '0',
                    ]);

                    break;

                default:
                    echo '<div class="alert alert-warning">Pratinjau tidak tersedia untuk tipe dokumen ini.</div>';

                    break;
            }
?>
        </div>
        <div class="card-footer text-muted">
            <?php echo Html::a(
                FAS::icon('download')
                .' Download',
                $documentUrl,
                ['class' => 'btn btn-primary',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer',
                ]
            ); ?>
        </div>
    </div>
</div>
