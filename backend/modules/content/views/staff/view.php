<?php

use common\models\Staff;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\service\FileDisplayService;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var array $officeOptions
 * @var array $jobTitleOptions
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'office_id',
                        'label' => Yii::t('backend', 'Office'),
                        'value' => static function ($model) use ($officeOptions) {
                            return $officeOptions[$model->office_id] ?? '-';
                        },
                    ],
                    [
                        'attribute' => 'job_title_id',
                        'label' => Yii::t('backend', 'JobTitle'),
                        'value' => static function ($model) use ($jobTitleOptions) {
                            return $jobTitleOptions[$model->job_title_id] ?? '-';
                        },
                    ],
                    'title',
                    'initial',
                    'identity_number',
                    'phone_number',
                    [
                        'attribute' => 'gender',
                        'value' => static function ($model) {
                            return Staff::genders()[$model->gender] ?? '-';
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'value' => static function ($model) {
                            return Staff::statuses()[$model->status] ?? '-';
                        },
                    ],
                    'address:ntext',
                    [
                        'label' => Yii::t('backend', 'Photo'),
                        'format' => 'raw',
                        'value' => static fn ($model) => FileDisplayService::renderImageOrFallback(
                            $model->title,
                            $model->base_url,
                            $model->path,
                            Yii::t('backend', 'No photo')
                        ),
                    ],
                    [
                        'attribute' => 'size',
                        'value' => static fn ($model) => FileDisplayService::formatSizeInKbOrMb($model->size),
                    ],
                    'email:email',
                    'description:ntext',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by',
                    'is_deleted',
                    'deleted_at',
                    'deleted_by',
                    'verlock',
                    'uuid',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
