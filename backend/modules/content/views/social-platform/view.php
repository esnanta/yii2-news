<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
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
                    'code',
                    'name',
                    'base_url:url',
                    'is_active',
                    'sequence',
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
