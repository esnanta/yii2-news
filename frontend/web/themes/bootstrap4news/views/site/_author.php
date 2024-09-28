<?php
use yii\helpers\Html;

$src    = str_replace('frontend', 'backend', $model->getImageUrl());   
$image  = Html::img($src, ['class' => 'd-flex u-shadow-v25 g-width-40 g-height-40 rounded-circle mr-3']);
?>


<article class="media g-mb-35">
    <?= Html::a($image, $model->getUrl()) ?>
    <div class="media-body">
        <h4 class="g-font-size-16">
            <?= Html::a($model->title, $model->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v1 g-color-primary--hover']) ?>
        </h4>
        <p class="g-color-gray-dark-v2">
            <?=$model->description;?>
        </p>
    </div>
</article>