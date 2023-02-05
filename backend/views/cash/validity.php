<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\ValidityDetail;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\ValiditySearch $searchModel
 */

$this->title = 'Validasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="validity-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Validity', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
            [
                'attribute' => 'updated_at',
                'format' => ['datetime'],
                'filter'=>false
            ], 
            [
                'label' => 'Validasi',
                'format'=>'html',
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', $model->getUrl());
                },
            ],            
            
            [
                'label' => 'Tagihan',
                'format'=>'html',
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-warning-sign"></span> Buat Tagihan ('.$model->countByBillingStatus(ValidityDetail::BILLING_STATUS_NO).')', 
                            Yii::$app->urlManager->createUrl(['billing/review', 'month' => $model->title])
                    );
                },
            ],                         
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
