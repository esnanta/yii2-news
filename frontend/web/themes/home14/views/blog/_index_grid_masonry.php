<?php
use yii\helpers\Html;

?>

<?php 
    $src = $model->getCover($model->content);
?>
<div class="">
    <div class="masonry-grid-sizer col-sm-1"></div>
    
    <article class="u-block-hover">
        <div class="g-bg-cover g-bg-white-gradient-opacity-v1--after">
            <?= Html::img($src, ['class' => 'u-block-hover__main--mover-down', 'alt'=>'Image Description','style' => 'width:400px;height:350px']);?>
        </div>
        <div class="g-pos-abs g-top-0 g-right-0 g-z-index-1 g-pa-35">
            <span class="d-block g-color-white g-font-weight-600 g-font-size-12">
                <?= Yii::$app->formatter->format($model->create_time, 'date');?>
            </span>
        </div>
        <div class="u-block-hover__additional--partially-slide-up g-z-index-1">
            <div class="u-block-hover__visible g-pa-25">
                <span class="d-block g-color-white-opacity-0_7 g-font-weight-600 g-font-size-12 mb-2"><?= $model->category->title;?></span>
                <h2 class="h2 g-color-white g-font-weight-600 mb-3">
                    <?= Html::a($model->title, $model->getUrl(),['class'=>'u-link-v5 g-color-white g-color-primary--hover g-cursor-pointer']); ?>
                </h2>
                <p class="g-color-white-opacity-0_7 mb-0">
                    <?php
                        echo $model->readMore();
                    ?> 
                </p>
            </div>

            <div class="g-pl-25">
                <?= Html::a('Read More', $model->getUrl(),['class'=>'d-inline-block g-brd-bottom g-brd-white g-color-white g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover g-mb-30']); ?>
            </div>
        </div>
    </article>    
</div>    