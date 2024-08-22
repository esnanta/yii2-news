<?php

use lesha724\documentviewer\ViewerJsDocumentViewer;
use yii\helpers\Html;
?>

<div class="card border-default mb-3">
    <div class="card-header">
        <?= $model->title; ?>

        <span class="pull-right">
            <?= Yii::t('app', 'Asset') ?>
        </span>
    </div>
    <div class="card-body text-default">

        <?php
        if (!empty($model->file_name)) {

            $assetUrl = $model->getAssetUrl();
            $tmp = explode('.', $model->asset);
            $ext = end($tmp);

            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                echo Html::img(str_replace('frontend', 'backend', $assetUrl), ['class' => 'img-fluid']);
                ?>

                <?php
            } else {
                echo ViewerJsDocumentViewer::widget([
                    'url' => $assetUrl,//url на ваш документ
                    'width' => '100%',
                    'height' => '300px',
                    //https://geektimes.ru/post/111647/
                ]);
            }
        }
        ?>
        <p><?= $model->description; ?></p>

        <div class="row">
            <div class="col-md-8">
                <!-- Contact Info -->
                <ul class="list-unstyled g-font-size-13 g-color-gray-dark-v4">
                    <li class="g-mb-5">
                        <i class="fa fa-calendar g-mr-10"></i>
                        <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                    </li>
                    <li class="g-mb-5">
                        <i class="fa fa-download g-mr-10"></i>
                        <?= (empty($model->download_counter)) ? 0 : $model->download_counter; ?>
                    </li>
                </ul>
                <!-- End Contact Info -->
            </div>
            <div class="col-md-4">
                <?= Html::a('DOWNLOAD', ['archive/download', 'id' => $model->id, 'title' => $model->title], ['class' => 'btn btn-md u-btn-primary g-mr-10 g-mb-15 pull-right']); ?>
            </div>
        </div>
    </div>
</div>
