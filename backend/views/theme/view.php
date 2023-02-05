<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\Theme $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="theme-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [

            'title',
            [
                'attribute'=>'description',
                'type'=>DetailView::INPUT_TEXTAREA,
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-theme'),
    ]) ?>




<?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $providerThemeDetail,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'token',
            'title',
            [
                'attribute' => 'content',
                'format'=>'html',
                'value' => function($model){
                    return $model->content;
                },
            ],
            'description:ntext',
            [
                'header'=>'Image',
                'format' => ['image',['width'=>'100','height'=>'60']],
                'vAlign'=>'middle',
                'width'=>'80px',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->getImageUrl();
                },
            ],

            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Yii::$app->urlManager->createUrl(['theme-detail/view', 'id' => $model->id]),
                            ['title' => Yii::t('yii', 'View'),
                                'class'=>'btn btn-sm btn-primary',]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['theme-detail/view', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),
                                'class'=>'btn btn-sm btn-info',]
                        );
                    }
                ],

            ],

        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
                        
        'bordered' => true,
        'striped' => false,
        'responsiveWrap' => false,
                        
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode("Theme Detail").' </h3>',
            'type' => 'primary',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>


</div>
