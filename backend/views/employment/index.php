<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\EmploymentSearch $searchModel
 */

$this->title = Yii::t('app', 'Employments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Employment',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dataProvider,
        
    'toolbar' => [
        [
            'content'=>
                Html::a('<i class="fas fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success'])
                 . ' '.
                Html::a('<i class="fas fa-redo"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'options' => ['class' => 'btn-group-md']
        ],
        //'{export}',
        //'{toggleData}'
    ],
        
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'office_id',
            'vAlign'=>'middle',
            'width'=>'120px',
            'value'=>function ($model, $key, $index, $widget) {
                return ($model->office_id!=null) ? $model->office->title:'';
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>$officeList,
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>''],
            'format'=>'raw'
        ],
        'title',
        'sequence',
        'description:ntext',
        [
            'class' => 'common\widgets\ActionColumn',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'template'=>'{update} {view}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a(
                        '<i class="fas fa-pencil-alt"></i>',
                        Yii::$app->urlManager->createUrl(['employment/view', 'id' => $model->id, 'edit' => 't']),
                        [
                            'title' => Yii::t('yii', 'Edit'),
                            'class'=>'btn btn-sm btn-info',
                        ]
                    );
                },

                'view' => function ($url, $model) {
                    return Html::a(
                        '<i class="fas fa-eye"></i>',
                        Yii::$app->urlManager->createUrl(['employment/view', 'id' => $model->id]),
                        [
                            'title' => Yii::t('yii', 'Edit'),
                            'class'=>'btn btn-sm btn-info',
                        ]
                    );
                },
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
            'type' => 'default',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            //'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
]);
Pjax::end(); ?>
    

</div>
