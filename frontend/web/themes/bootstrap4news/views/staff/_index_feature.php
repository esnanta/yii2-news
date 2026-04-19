<?php

use common\models\Staff;
use common\models\StaffSocialAccount;
use yii\helpers\Html;

/**
 * @var Staff $model
 */
$img = Html::img(str_replace('frontend', 'backend', $model->getUrl()), [
    'class' => 'img-fluid rounded-circle mb-3 shadow-sm',
    'alt' => $model->title,
    'style' => 'width: 150px; height: 150px; object-fit: cover;',
]);

$linkClass = 'text-dark font-weight-bold';

?>

<div class="card h-100 shadow-sm border-0 staff-card">
    <div class="card-body text-center">
        <div class="mb-4">
            <?php echo $img; ?>
        </div>

        <h5 class="card-title mb-1">
            <?php echo Html::a(Html::encode($model->title), $model->getViewUrl(), ['class' => $linkClass]); ?>
        </h5>

        <em class="d-block text-uppercase text-primary mb-3" style="font-size: 0.9rem;">
            <?php echo $model->job_title_id ? $model->jobTitle->title : 'Not Set'; ?>
        </em>

        <p class="card-text text-muted small"><?php echo Html::encode($model->description); ?></p>
    </div>

    <div class="card-footer bg-white border-top-0 pt-0">
        <?php $staffMedias = StaffSocialAccount::find()->where(['staff_id' => $model->id])->all(); ?>
        <?php if ($staffMedias) { ?>
            <ul class="list-inline text-center mb-0">
                <?php foreach ($staffMedias as $staffMediaItem) { ?>
                    <li class="list-inline-item mx-2">
                        <?php echo Html::a(
                            '<i class="'.$staffMediaItem->title.' fa-lg"></i>',
                            $staffMediaItem->description,
                            [
                                'class' => 'text-muted social-icon',
                                'target' => '_blank',
                                'rel' => 'noopener noreferrer',
                            ]
                        ); ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>

<style>
.staff-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.staff-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.social-icon i {
    transition: color 0.3s ease;
}
.social-icon:hover i {
    color: #007bff !important;
}
</style>
