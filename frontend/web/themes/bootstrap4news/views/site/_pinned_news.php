<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

$articleCover   = str_replace('frontend', 'backend',
    ContentHelper::getCover($model->content));
?>

<!-- Article -->
<article>
    <span class="g-font-size-12">
        <?= Html::a($model->author->title, $model->author->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v4']) ?>
    </span>
    <h3 class="h6">
        <?= Html::a($model->title, $model->getUrl(), ['class' => 'g-color-gray-dark-v1']) ?>
    </h3>
</article>
<!-- End Article -->