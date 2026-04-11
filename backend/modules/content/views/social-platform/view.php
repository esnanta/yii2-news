<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/*
 * @var yii\web\View $this
 * @var common\models\SocialPlatform $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Platforms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-platform-view">
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
                    'code',
                    'name',
                    'base_url:url',
                    [
                        'attribute' => 'is_active',
                        'value' => $model->isActiveLabel,
                    ],
                    'sequence',
                ],
            ]); ?>
        </div>
    </div>
</div>
