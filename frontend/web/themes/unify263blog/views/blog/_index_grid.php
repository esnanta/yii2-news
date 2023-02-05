<?php

use yii\helpers\Html;

$unset = '#NA';
?>

<?php
$src = str_replace('frontend', 'backend', $model->getCover($model->content));
$vid = '';
if (strpos($src, 'iframe') !== false) {
    echo $vid = $scr;
}
?>


<?php if(substr($src, 0, 2)=='//'){ ?>

        <div class="responsive-video margin-bottom-15" >
            <iframe 
                allowfullscreen="" 
                frameborder="0" 
                src="<?=$src;?>?controls=0" 
                width="100%"
                height="250" 
                >
            </iframe>
        </div>



<?php } else{ ?>

        <?=Html::img($src, ['class' => 'img-fluid w-100']);?>

<?php } ?>
    

<article class="u-shadow-v11">
    <div class="g-bg-white g-pa-30">
        <span class="d-block g-color-gray-dark-v4 g-font-weight-600 g-font-size-12 text-uppercase mb-2">
            <?= $model->category->title.' / '.Yii::$app->formatter->format($model->created_at, 'date'); ?>
        </span>
        <h2 class="h5 g-color-black g-font-weight-600 mb-3">
            <?= Html::a($model->title, $model->getUrl(), ['class' => 'u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer']) ?>
        </h2>

        <span class="g-color-gray-dark-v4 g-line-height-1_8">
            <?= strip_tags($model->readMore()); ?>
        </span>
        <p>
            <?= Html::a('Read More...', $model->getUrl(), ['class' => 'g-font-size-13']) ?>
        <p>

        <hr class="g-my-20">

        <ul class="list-inline d-flex justify-content-between mb-0">           
            <li class="list-inline-item g-color-gray-dark-v4">
                <span class="d-inline-block g-color-gray-dark-v4 g-font-size-13 g-cursor-pointer g-text-underline--none--hover">
                    <i class="align-middle g-font-size-default mr-1 icon-eye u-line-icon-pro"></i>
                    <?= $model->view_counter; ?>
                </span>
            </li>
            <li class="list-inline-item g-color-gray-dark-v4">
                <i class="align-middle g-color-primary g-font-size-default mr-1 icon-user u-line-icon-pro"></i>
                <span class="d-inline-block g-color-gray-dark-v4 g-font-size-13 g-cursor-pointer g-text-underline--none--hover">
                    <?= $model->author->title; ?>
                </span>
            </li>             
        </ul>
    </div>
</article>
