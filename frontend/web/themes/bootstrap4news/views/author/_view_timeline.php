<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

$articleCover = ContentHelper::getCover($model->content);

$vid = '';
if (strpos($articleCover, 'iframe') !== false) {
    echo $vid = $scr;
}
?>

<?php
if ($vid !== '') {
    ?>
    <div class="embed-responsive embed-responsive-16by9" style="width:120px;height:75px">
        <iframe src="<?php echo $vid; ?>" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    </div>
    <?php
} else {
    $img = Html::img($articleCover, ['class' => 'img-fluid rounded-circle']);
}
?>

<div class="position-relative mb-3">
    <i class="d-inline-block position-absolute bg-white border border-gray rounded-circle" style="width:16px; height:16px; left:50%; top:50%; transform:translate(-50%, -50%); z-index:3;"></i>
</div>

<div class="row no-gutters mb-4 p-3 border-bottom">
    <!-- Image and date section -->
    <div class="col-md-3 order-2 order-md-1 d-flex flex-column align-items-center pr-md-4">
        <!-- Image -->
        <div class="rounded-circle overflow-hidden mb-2" style="width:120px; height:120px;">
            <?= $img; ?>
        </div>
        <!-- Date -->
        <div class="w-100 text-center border-bottom border-gray">
            <span class="d-block font-weight-bold text-white bg-dark p-2"><?= Yii::$app->formatter->format($model->created_at, 'date'); ?></span>
        </div>
    </div>

    <!-- Content section -->
    <div class="col-md-9 order-1 order-md-2 mb-3 mb-md-0 pl-md-4">
        <div class="media d-flex">
            <div class="media-body align-self-center">
                <h3 class="text-uppercase font-weight-bold text-dark mb-2"><?= Html::a($model->title, $model->getUrl(), ['class' => 'text-dark']); ?></h3>

                <p class="text-muted mb-2">
                    <?= strip_tags(ContentHelper::readMore($model->content)); ?>
                    <?= Html::a('(Read more)', $model->getUrl(), ['class' => 'text-muted small']) ?>
                </p>
            </div>
        </div>
    </div>
</div>
