<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\ThemeDetailSearch $searchModel
 */

$this->title = 'ThemeDetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php  echo $this->render('unify263blog/home', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'dataList'=>$dataList
            
            ]
            ); ?>

    <?php 
    
//    Pjax::begin(); echo GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            [
//                'attribute'=>'theme_id',
//                'vAlign'=>'middle',
//                'width'=>'180px',
//                'value'=>function ($model, $key, $index, $widget) {
//                    return ($model->theme_id!=null) ? $model->theme->title:'';
//                },
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>$dataList,
//                'filterWidgetOptions'=>[
//                    'pluginOptions'=>['allowClear'=>true],
//                ],
//                'filterInputOptions'=>['placeholder'=>''],
//                'format'=>'raw'
//            ],
//
//            'token',
//            'title',
//            [
//                'attribute' => 'content',
//                'format'=>'html',
//                'value' => function($model){
//                    return $model->content;
//                },
//            ],
//            'description:ntext',
//            [
//                'header'=>'Image',
//                'format' => (!empty($model->file_name)) ? ['image',['width'=>'100','height'=>'100']] : 'raw',
//                'vAlign'=>'middle',
//                'width'=>'80px',
//                'value'=>function ($model, $key, $index, $widget) {
//                    return ($model->getImageUrl());
//                },
//            ],
//
//            [
//                'class' => 'common\widgets\ActionColumn',
//                'contentOptions' => ['style' => 'white-space:nowrap;'],
//                'template'=>'{update} {view}',
//                'buttons' => [
//                    'update' => function ($url, $model) {
//                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
//                            Yii::$app->urlManager->createUrl(['theme-detail/view', 'id' => $model->id, 'edit' => 't']),
//                            [
//                                'title' => Yii::t('yii', 'Edit'),
//                                'class'=>'btn btn-sm btn-info',
//                            ]
//                        );
//                    }
//                ],
//            ],
//        ],
//        'responsive' => true,
//        'hover' => true,
//        'condensed' => true,
//        'floatHeader' => false,
//                        
//        'bordered' => true,
//        'striped' => false,
//        'responsiveWrap' => false,
//
//        'panel' => [
//            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
//            'type' => 'info',
//            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
//            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
//            'showFooter' => false
//        ],
//    ]); Pjax::end(); 
    
    ?>

</div>
