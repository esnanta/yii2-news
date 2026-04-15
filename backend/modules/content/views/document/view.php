<?php

use common\service\FileDisplayService;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 * @var array $officeOptions
 * @var array $documentCategoryOptions
 * @var array $visibleOptions
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(
                Yii::t('backend', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            ); ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]); ?>
            <?php if (!empty($model->path)) { ?>
                <?php echo Html::a(
                    Yii::t('backend', 'Download'),
                    ['download', 'id' => $model->id],
                    ['class' => 'btn btn-secondary']
                ); ?>
            <?php } ?>
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
                            'attribute' => 'is_visible',
                            'label' => Yii::t('backend', 'Is Visible'),
                            'value' => static function ($model) use ($visibleOptions) {
                                return $visibleOptions[$model->is_visible] ?? '-';
                            },
                        ],
                        [
                            'attribute' => 'category_id',
                            'label' => Yii::t('backend', 'Category'),
                            'value' => static function ($model) use ($documentCategoryOptions) {
                                return $documentCategoryOptions[$model->category_id] ?? null;
                            },
                        ],
                        'title',
                        'date_issued',
                        [
                            'attribute' => 'size',
                            'value' => static fn ($model) => FileDisplayService::formatSizeInKbOrMb($model->size),
                        ],
                        'view_count',
                        'download_count',
                        'description:ntext',
                        'created_at',
                        'updated_at',
                    ],
                ]); ?>
        </div>
    </div>
</div>
