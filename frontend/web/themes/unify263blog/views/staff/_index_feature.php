<?php
use yii\helpers\Html;
?>

<?php
    $img = Html::img(str_replace('frontend', 'backend', $model->getImageUrl()), [
        'class'=>'w-100 g-mb-30',
    ],['alt' => $model->title]);
?>

<!-- Figure -->
<figure class="g-color-gray-dark-v2">
    <!-- Figure Image -->
    <?= $img; ?>
    <!-- End Figure Image -->

    <!-- Figure Info -->
    <em class="d-block g-font-style-normal g-font-size-11 text-uppercase g-color-primary g-mb-5">
        <?= (!empty($model->employment_id)) ? $model->employment->title:'Not Set';?>
    </em>

    <h4 class="h5 g-color-black-light-v3 g-mb-5">
        <?= Html::a($model->title, $model->getUrl(), ['class' => 'u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer']) ?>
    </h4>

    <p class="g-font-size-13 g-color-gray-dark-v4"><?= $model->description?></p>
    <!-- End Info -->

    <hr class="g-brd-gray-light-v4 g-my-15">

    <!-- Contact Info -->
    <ul class="list-unstyled g-font-size-13 g-color-gray-dark-v4">
        <?php if(!empty($model->instagram)){?>
            <li class="g-mb-5">
                <i class="fa fa-instagram g-mr-10"></i>
                <?= ($model->instagram==null) ? '': $model->instagram?>
            </li>
        <?php } ?>

        <?php if(!empty($model->twitter)){?>
            <li class="g-mb-5">
                <i class="fa fa-twitter g-mr-10"></i>
                <?= $model->twitter?>
            </li>
        <?php } ?>

        <?php if(!empty($model->google_plus)){?>
            <li class="g-mb-5">
                <i class="fa fa-google-plus g-mr-10"></i>
                <?= $model->google_plus?>
            </li>
        <?php } ?>

        <?php if(!empty($model->facebook)){?>
            <li class="g-mb-5">
                <i class="fa fa-facebook g-mr-10"></i>
                <?= $model->facebook?>
            </li>
        <?php } ?>
    </ul>
    <!-- End Contact Info -->
</figure>
<!-- End Figure -->