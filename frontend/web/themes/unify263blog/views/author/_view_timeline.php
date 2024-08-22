<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

?>

<?php

$articleCover = str_replace('frontend', 'backend',
    ContentHelper::getCover($model->content));

$vid = '';
if (strpos($articleCover, 'iframe') !== false) {
    echo $vid = $scr;
}
?>
<?php
if ($vid <> '') {
    ?>
    <div class="embed-responsive embed-responsive-16by9 full-width" style="width:120px;height:75px">
        <iframe src="<?php echo $vid; ?>" webkitallowfullscreen mozallowfullscreen
                allowfullscreen>
        </iframe>
    </div>
    <?php
} else {
    $img = Html::img($articleCover, ['class' => 'img-fluid g-rounded-50x']);
}
?>


<div class="g-hidden-sm-down u-timeline-v3__icon g-absolute-centered--y g-z-index-3 g-width-16 g-height-16 g-ml-minus-8">
    <i class="d-inline-block g-width-16 g-height-16 g-bg-white g-brd-5 g-brd-style-solid g-brd-gray-light-v4 g-rounded-50"></i>
</div>

<div class="row mx-0">
    <div class="col-md-3 g-order-2 g-order-1--sm d-flex align-self-center px-0">
        <div class="u-heading-v1-4 g-brd-gray-light-v4 w-100">
                <span class="text-center g-pos-rel d-block g-width-115 g-font-weight-600 g-color-white g-font-size-14 g-bg-gray-dark-v1 g-bg-primary--parent-hover g-py-5 g-px-10 mx-auto g-ml-0--md g-transition-0_2 g-transition--ease-in">
                    <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                </span>
        </div>
    </div>

    <div class="col-md-9 g-order-1 g-order-2--sm px-0 g-mb-15 g-mb-0--md">
        <div class="media d-block d-md-flex">
            <div class="d-md-flex g-width-120 g-width-170--md g-height-120 g-height-170--md g-overlay-black-0_7 g-overlay-none--parent-hover g-rounded-50x g-mr-30--md mx-auto g-mb-15 g-mb-0--md g-transition-0_2 g-transition--ease-in">
                <?= $img; ?>
            </div>

            <div class="media-body align-self-center">
                <h4 class="text-uppercase g-font-weight-600 g-font-size-12 g-color-primary g-mb-5">
                    <?= $model->articleCategory->title; ?>
                </h4>
                <h3 class="text-uppercase g-font-weight-600 g-font-size-22 g-color-gray-dark-v1 g-mb-10"><?= Html::a($model->title, $model->getUrl(), ['style' => 'color:black']); ?></h3>

                <p class="g-color-gray-dark-v5 mb-0">
                    <?= strip_tags(ContentHelper::readMore($model->content)); ?>
                </p>
                <?= Html::a('Read More...', $model->getUrl(), ['class' => 'g-font-size-13']) ?>
            </div>
        </div>
    </div>
</div>

