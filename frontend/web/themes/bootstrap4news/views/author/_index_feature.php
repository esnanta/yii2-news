<?php

namespace frontend\themes\unify263\views\author\index;

use yii\helpers\Html;

$labelInstagram     = (!empty($model->instagram))   ? 'g-color-blue g-color-white--hover g-bg-primary--hover rounded-circle' : 'g-color-gray-dark-v5';
$labelTwitter       = (!empty($model->twitter))     ? 'g-color-blue g-color-white--hover g-bg-primary--hover rounded-circle' : 'g-color-gray-dark-v5';
$labelFacebook      = (!empty($model->facebook))    ? 'g-color-blue g-color-white--hover g-bg-primary--hover rounded-circle' : 'g-color-gray-dark-v5';

?>

<?php
    $img = Html::img(str_replace('frontend', 'backend', $model->getImageUrl()), [
        'class'=>'g-width-100 g-height-100 rounded-circle g-mb-30',
        'style'=>'width:100px;height:100px'
    ],['alt' => $model->title]);
?>

<!-- Figure -->
<figure class="u-shadow-v21 u-shadow-v21--hover g-brd-around g-brd-gray-light-v4 g-bg-white g-rounded-4 text-center g-transition-0_3">
    <div class="g-py-40 g-px-20">
        <!-- Figure Image -->
        <?= $img; ?>
        <!-- Figure Image -->

        <!-- Figure Info -->
        <h4 class="g-font-weight-600 g-font-size-16 g-mb-15"><?= $model->title ?></h4>

<!--        <a class="d-block g-color-primary g-font-weight-600 g-font-size-13 g-mb-15" href="mailto:<?= (!empty($model->email)) ? $model->email:''; ?>">          
            <?php // (!empty($model->email)) ? $model->email:''; ?>     
        </a>        -->
        
        <ul class="list-inline mb-0">
            <li class="list-inline-item mx-1">

                <span class="tooltips-show u-icon-v1 u-icon-size--sm <?=$labelInstagram;?>"
                    data-toggle="tooltip" data-original-title="<?=(!empty($model->instagram)) ? $model->instagram:'-';?>">
                    <i class="fa fa-instagram"></i>
                </span>                   
            </li>
            <li class="list-inline-item mx-1">
                <span class="tooltips-show u-icon-v1 u-icon-size--sm <?=$labelTwitter;?>"
                    data-toggle="tooltip" data-original-title="<?=(!empty($model->twitter)) ? $model->twitter:'-';?>">
                    <i class="fa fa-twitter"></i>
                </span>                
            </li>
            <li class="list-inline-item mx-1">
                <span class="tooltips-show u-icon-v1 u-icon-size--sm <?=$labelFacebook;?>"
                    data-toggle="tooltip" data-original-title="<?=(!empty($model->facebook)) ? $model->facebook:'-';?>">
                    <i class="fa fa-facebook"></i>
                </span>
            </li>
        </ul>
        <!-- End Figure Info -->
    </div>

    <!-- Figure Footer -->
    <footer class="d-flex justify-content-between g-bg-gray-light-v5 g-py-20 g-px-40">
        <span class="g-color-gray-dark-v5 g-color-primary--hover g-font-size-13 g-text-underline--none--hover">            
            <i class="icon-user"></i>
            <small><?= (!empty($model->email)) ? $model->email:''; ?>   </small>
            
        </span>
        <?= Html::a('<i class="fa fa-angle-double-right"></i> See Profile', $model->getUrl(),['class'=>'g-color-gray-dark-v5 g-color-primary--hover g-font-size-13 g-text-underline--none--hover']); ?>
    </footer>
    <!-- End Figure Footer -->
</figure>
<!-- End Figure -->