<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
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
                    'office_id',
                    'employment_id',
                    'title',
                    'initial',
                    'identity_number',
                    'phone_number',
                    'gender_status',
                    'active_status',
                    'address:ntext',
                    'base_url:url',
                    'path',
                    'name',
                    'type',
                    'size',
                    'email:email',
                    'google_plus',
                    'instagram',
                    'facebook',
                    'twitter',
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
