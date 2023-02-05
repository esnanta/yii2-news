<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\CustomerSearch $searchModel
 */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Customer', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            'title', 
            'phone_number', 
            'address:ntext', 
                  
            [
                'attribute'=>'gender_status', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value' => function($model){
                    if ($model->gender_status)
                    {return $model->getOneModule($model->gender_status);}
                    else
                    {return NULL;}
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=> $genderList,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],                         
                        
//            [
//                'attribute'=>'area_id', 
//                'vAlign'=>'middle',
//                'width'=>'180px',
//                'value' => function($model){
//                    if ($model->area_id)
//                    {return Html::a($model->area->title, $model->area->getUrl());}
//                    else
//                    {return NULL;}
//                },
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>$areaList, 
//                'filterWidgetOptions'=>[
//                    'pluginOptions'=>['allowClear'=>true],
//                ],
//                'filterInputOptions'=>['placeholder'=>''],
//                'format'=>'raw'
//            ],  

            [
                'attribute'=>'village_id', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value' => function($model){
                    if ($model->village_id)
                    {return Html::a($model->village->title, $model->village->getUrl());}
                    else
                    {return NULL;}
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$villageList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],             
            
            [
                'attribute' => 'date_issued_range',
                'value'=>'date_issued',
                'format'=>'date',
                'options' => [
                    'format' => 'd-m-Y',
                ],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'date_issued_range',
                    'presetDropdown' => false,
                    'convertFormat' => true,
                    'pluginOptions'=>[
                        'locale'=>['format' => 'd-m-Y'],
                    ]                
                ])
            ],                        
                        
            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{update} {view}',                
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['customer/view', 'id' => $model->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Edit'),
                                'class'=>'btn btn-sm btn-info',
                            ]
                        );
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['/site/new-customer'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
