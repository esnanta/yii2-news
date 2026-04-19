<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var yii\data\ActiveDataProvider $dataProviderSocial
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$img = Html::img(str_replace('frontend', 'backend', $model->getUrl()), [
    'class' => 'img-fluid rounded-circle',
]);
?>

<div class="container mt-4">

    <div class="row">
        <!-- Profile Image -->
        <div class="col-md-3 text-center mb-4">
            <div class="card">
                <div class="card-body">
                    <?php echo $img; ?>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-md-9">
            <div class="d-flex align-items-center mb-2">
                <h2 class="font-weight-bold mr-2 h5"><?php echo $model->title; ?></h2>
                <div>
                    <ul class="list-inline mb-0">
                        <?php foreach ($dataProviderSocial->models as $staffMediaItem) { ?>
                            <li class="list-inline-item">
                                <?php echo Html::a(
                                    '<i class="fa '.$staffMediaItem->title.'"></i>',
                                    $staffMediaItem->description,
                                    ['class' => 'text-secondary small']
                                ); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <ul class="list-inline text-muted small mb-3">
                <li class="list-inline-item">
                    <i class="fa fa-briefcase mr-1"></i>
                    <?php echo !empty($model->job_title_id) ? $model->jobTitle->title : 'Not Set'; ?>
                </li>
                <li class="list-inline-item">
                    <i class="fa fa-map-marker-alt mr-1"></i><?php echo $model->address ?? '-'; ?>
                </li>
                <li class="list-inline-item">
                    <i class="fa fa-phone-alt mr-1"></i><?php echo $model->phone_number ?? '-'; ?>
                </li>
            </ul>

            <p class="lead"><?php echo $model->description ?? 'No description provided.'; ?></p>

        </div>
    </div>
</div>
