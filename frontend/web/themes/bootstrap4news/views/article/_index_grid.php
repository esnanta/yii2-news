<?php

use common\helpers\ContentHelper;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;

$unset = '#NA';
?>

<?php
$content = $model->content;
$articleCover = ContentHelper::getCover($model->content, $model->cover);
$vid = '';

if (false !== strpos($articleCover, 'iframe')) {
    echo $vid = $scr;
}
?>

<?php if ('//' == substr($articleCover, 0, 2)) { ?>

    <div class="embed-responsive embed-responsive-16by9 mb-3">
        <iframe
                allowfullscreen
                frameborder="0"
                src="<?php echo $articleCover; ?>?controls=0"
                class="embed-responsive-item">
        </iframe>
    </div>

<?php } else { ?>

    <?php echo Html::img($articleCover, ['class' => 'img-fluid w-100 mb-3', 'height' => '200px']); ?>

<?php } ?>

<article class="shadow-sm">
    <div class="bg-white p-3">
        <span class="d-block text-muted text-uppercase small mb-2">
            <?php echo $model->articleCategory->title.' / '.Yii::$app->formatter->format($model->created_at, 'date'); ?>
        </span>

        <h2 class="h5 font-weight-bold mb-3">
            <?php echo Html::a($model->title, $model->getUrl(), ['class' => 'text-dark text-decoration-none hover-primary']); ?>
        </h2>

        <p class="text-muted">
            <?php echo strip_tags(ContentHelper::readMore($content)); ?>
            <?php echo Html::a('(Read more)', $model->getUrl(), ['class' => 'small text-primary']); ?>
        </p>

        <hr>

        <ul class="list-inline d-flex justify-content-between mb-0">
            <li class="list-inline-item text-muted small">
                 <?php echo FAS::icon('eye').' '
                         .$model->view_count; ?>
            </li>
            <li class="list-inline-item text-muted small">
                <?php echo FAS::icon('user').' '
                .Html::a($model->author->title, $model->author->getUrl(), ['class' => 'small']); ?>
            </li>
        </ul>
    </div>
</article>
