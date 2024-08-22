<?php

use common\models\StaffMedia;
use yii\helpers\Html;
?>
<style>
    .list-unstyled {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .list-unstyled li {
        display: flex;
        justify-content: center;
        width: 100%;
    }
</style>
<?php
    $img = Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()), [
        'class'=>'w-100 g-mb-30',
    ]);
    $linkClass = 'u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer';
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
        <?= Html::a($model->title, $model->getUrl(), ['class' => $linkClass]) ?>
    </h4>

    <p class="g-font-size-13 g-color-gray-dark-v4"><?= $model->description?></p>
    <!-- End Info -->

    <hr class="g-brd-gray-light-v4 g-my-15">

    <!-- Contact Info -->
    <?php
        $staffMedias = StaffMedia::find()->where(['staff_id' => $model->id])->all();
    ?>
    <ul class="list-unstyled g-font-size-13 g-color-gray-dark-v4 ">
        <?php foreach ($staffMedias as $staffMediaItem): ?>

            <li class="g-mb-5">
                <?php
                    $title = '<i class="' . $staffMediaItem->title . ' g-mr-10"></i>';
                ?>
                <?= Html::a($title, $staffMediaItem->description, ['class' => $linkClass]) ?>
            </li>
        <?php endforeach;?>
    </ul>
    <!-- End Contact Info -->
</figure>
<!-- End Figure -->