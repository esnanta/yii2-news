<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\VillageSearch $searchModel
 */

$this->title = 'Villages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="village-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Village', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute' => 'area_id',
                    'label' => 'Area',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->area_id)
                        {return Html::a($model->area->title, $model->area->getUrl());}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $areaList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Area', 'id' => 'grid-outlet-search-area_id']
            ],
            'title',
            'description:ntext',

            [
                'label' => 'Pelanggan',
                'format'=> 'html',
                'value' => function($model){

                    return Html::a('Export ('.$model->getCustomersCount().')', ['report-customer/village','id'=>$model->id]);
                }
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>