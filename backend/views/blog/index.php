<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\BlogSearch $searchModel
 */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Blog', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>
    
    
<?php
//use yii\helpers\Url;
//    $files=\yii\helpers\FileHelper::findFiles('uploads/blog/');
//    if (isset($files[0])) {
//        foreach ($files as $index => $file) {
//            $nameFicheiro = substr($file, strrpos($file, '/') + 1);
//            echo Html::a($nameFicheiro, Url::base().'/uploads/blog/'.$nameFicheiro) . "<br/>" . "<br/>" ; // render do ficheiro no browser
//        }
//    } else {
//        echo "There are no files available for download.";
//    }
?>
    
    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'title',
            
            [
                'attribute'=>'author_id', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->author_id!=null) ? $model->author->title:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$authorList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ], 
                        
            [
                'attribute'=>'category_id', 
                'format'=>'html',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->category_id!=null) ? $model->category->title:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$categoryList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],
            

            [
                'attribute'=>'publish_status', 
                'label'=>'Status',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->publish_status!=null) ? $model->getOnePublishStatus($model->publish_status):'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$publishList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],                         
                        
            [
                'attribute'=>'pinned_status', 
                'label'=>'Pinned',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->pinned_status!=null) ? $model->getOnePinnedStatus($model->pinned_status):'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$pinnedList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ], 
                        
            'view_counter',
                        
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
                            Yii::$app->urlManager->createUrl(['blog/view', 'id' => $model->id, 'edit' => 't']),
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
        'floatHeader' => false,
                        
        'bordered' => true,
        'striped' => false,
        'responsiveWrap' => false,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
