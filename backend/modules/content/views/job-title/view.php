<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\JobTitle $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Job Titles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-title-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary']); ?>
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
                    'title',
                    'description:ntext',
                    'sequence',
                    'created_at',
                    'updated_at',
                ],
            ]); ?>
        </div>
    </div>
</div>
