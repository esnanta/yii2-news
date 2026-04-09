<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var common\models\search\StaffSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Staff');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Staff',
]), ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'office_id',
                    'user_id',
                    'employment_id',
                    'title',
                    // 'initial',
                    // 'identity_number',
                    // 'phone_number',
                    // 'gender_status',
                    // 'active_status',
                    // 'address:ntext',
                    // 'base_url:url',
                    // 'path',
                    // 'name',
                    // 'type',
                    // 'size',
                    // 'email:email',
                    // 'google_plus',
                    // 'instagram',
                    // 'facebook',
                    // 'twitter',
                    // 'description:ntext',
                    // 'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',
                    // 'is_deleted',
                    // 'deleted_at',
                    // 'deleted_by',
                    // 'verlock',
                    // 'uuid',
                    
                    ['class' => \common\widgets\ActionColumn::class],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
