<?php

use common\models\StaffMedia;
use yii\helpers\Html;

/**
 * @var $model common\models\Staff
 */

$img = Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()), [
    'class' => 'img-fluid rounded mb-3',
    'alt' => $model->title,
]);

$linkClass = 'text-dark font-weight-bold';

?>

<div class="card h-100">
    <div class="card-body text-center">
        <?= $img ?>

        <em class="d-block text-uppercase text-primary mb-2">
            <?= $model->employment_id ? $model->employment->title : 'Not Set'; ?>
        </em>

        <h5 class="card-title">
            <?= Html::a(Html::encode($model->title), $model->getUrl(), ['class' => $linkClass]) ?>
        </h5>

        <p class="card-text text-muted"><?= Html::encode($model->description) ?></p>
    </div>

    <div class="card-footer bg-transparent border-top-0">
        <?php $staffMedias = StaffMedia::find()->where(['staff_id' => $model->id])->all(); ?>
        <ul class="list-inline text-center mb-0">
            <?php foreach ($staffMedias as $staffMediaItem): ?>
                <li class="list-inline-item">
                    <?= Html::a('<i class="' . $staffMediaItem->title . '"></i>', $staffMediaItem->description, [
                        'class' => 'text-muted',
                        'target' => '_blank',
                        'rel' => 'noopener noreferrer'
                    ]) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
