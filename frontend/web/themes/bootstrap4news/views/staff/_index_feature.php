<?php

use common\models\Staff;
use common\models\StaffSocialAccount;
use yii\helpers\Html;

/**
 * @var Staff $model
 */
$img = Html::img(str_replace('frontend', 'backend', $model->getUrl()), [
    'class' => 'img-fluid rounded mb-3',
    'alt' => $model->title,
]);

$linkClass = 'text-dark font-weight-bold';

?>

<div class="card h-100">
    <div class="card-body text-center">
        <?php echo $img; ?>

        <em class="d-block text-uppercase text-primary mb-2">
            <?php echo $model->job_title_id ? $model->jobTitle->title : 'Not Set'; ?>
        </em>

        <h5 class="card-title">
            <?php echo Html::a(Html::encode($model->title), $model->getUrl(), ['class' => $linkClass]); ?>
        </h5>

        <p class="card-text text-muted"><?php echo Html::encode($model->description); ?></p>
    </div>

    <div class="card-footer bg-transparent border-top-0">
        <?php $staffMedias = StaffSocialAccount::find()->where(['staff_id' => $model->id])->all(); ?>
        <ul class="list-inline text-center mb-0">
            <?php foreach ($staffMedias as $staffMediaItem) { ?>
                <li class="list-inline-item">
                    <?php echo Html::a('<i class="'.$staffMediaItem->title.'"></i>', $staffMediaItem->description, [
                        'class' => 'text-muted',
                        'target' => '_blank',
                        'rel' => 'noopener noreferrer',
                    ]); ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
