<?php

use common\service\FileDisplayService;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 * @var array $officeOptions
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]); ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'office_id',
                        'label' => Yii::t('backend', 'Office'),
                        'value' => static function ($model) use ($officeOptions) {
                            return $officeOptions[$model->office_id] ?? null;
                        },
                    ],
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
                    'title',
                    'phone_number',
                    'email:email',
                    'address:ntext',
                    'description:ntext',
                ],
            ]); ?>
        </div>
    </div>
</div>
