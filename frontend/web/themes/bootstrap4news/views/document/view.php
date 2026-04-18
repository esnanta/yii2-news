<?php

use common\models\Document;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$previewUrl = Url::to(['preview', 'id' => $model->id]);
$downloadUrl = Url::to(['download', 'id' => $model->id]);
$absolutePreviewUrl = Url::to(['preview', 'id' => $model->id], true);
$canUseOfficeViewer = 0 === strpos($absolutePreviewUrl, 'https://');
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
                    echo Html::img($previewUrl, ['class' => 'img-fluid', 'alt' => $model->title]);

                    break;

                case Document::TYPE_PDF:
                    echo Html::tag('iframe', '', [
                        'src' => $previewUrl,
                        'width' => '100%',
                        'height' => '800px',
                        'style' => 'border: none;',
                    ]);

                    break;

                case Document::TYPE_OFFICE_DOCUMENT:
                    if ($canUseOfficeViewer) {
                        $officeViewerUrl = 'https://view.officeapps.live.com/op/embed.aspx?src='
                            .rawurlencode($absolutePreviewUrl);
                        echo Html::tag('iframe', 'Your browser does not support iframes.', [
                            'src' => $officeViewerUrl,
                            'width' => '100%',
                            'height' => '800px',
                            'frameborder' => '0',
                        ]);
                    } else {
                        echo Html::tag(
                            'div',
                            Html::encode('Office preview needs a publicly reachable HTTPS URL. Please use Download.'),
                            ['class' => 'alert alert-info']
                        );
                    }

                    break;

                default:
                    echo '<div class="alert alert-warning">Preview is not available for this document type.</div>';

                    break;
            }
            ?>
        </div>
        <div class="card-footer text-muted">
            <?php echo Html::a(
                FAS::icon('download')
                .' Download',
                $downloadUrl,
                ['class' => 'btn btn-primary']
            ); ?>
        </div>
    </div>
</div>
