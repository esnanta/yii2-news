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

    <?php
        Pjax::begin(); echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'title', //NOMOR PELANGGAN

                [
                    'attribute' => 'customer_title',
                    'label' => Yii::$app->params['Attribute_Customer'],
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->customer_id)
                        {return Html::a($model->customer->title, $model->customer->getUrl());}
                        else
                        {return NULL;}
                    },
                ],
                [
                    'attribute' => 'customer_phone_number',
                    'label' => Yii::$app->params['Attribute_PhoneNumber'],
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->customer_id)
                        {return $model->customer->phone_number;}
                        else
                        {return NULL;}
                    },
                ],
                [
                    'attribute' => 'customer_address',
                    'label' => Yii::$app->params['Attribute_Address'],
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->customer_id)
                        {return $model->customer->address;}
                        else
                        {return NULL;}
                    },
                ],
                [
                    'attribute' => 'enrolment_type',
                    'format'=>'html',
                    //'label' => 'Jenis',
                    'value' => function($model){
                        if ($model->enrolment_type)
                        {return ($model->enrolment_type!=null) ? $model->getOneEnrolmentType($model->enrolment_type):'';}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $enrolmentTypeList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-enrolment-search-enrolment_type']
                ],
                [
                    'attribute' => 'days_of_valid',
                    'label' => 'Valid',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->enrolment_type==backend\models\Enrolment::ENROLMENT_TYPE_DIGITAL)
                        {return $model->getDaysOfValid();}
                        else
                        {return NULL;}
                    },
                ],
                [
                    'attribute' => 'days_of_expired',
                    'label' => 'Expired',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->enrolment_type==backend\models\Enrolment::ENROLMENT_TYPE_DIGITAL)
                        {return $model->getDaysOfExpired();}
                        else
                        {return NULL;}
                    },
                ],

                [
                    'label' => 'Histori',
                    'format'=> 'html',
                    'value' => function($model){

                        return Html::a('Export', ['report-customer/history','id'=>$model->id]);
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
                //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['/customer/select','module'=>'enrolment'], ['class' => 'btn btn-success']),
                'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                'showFooter' => false
            ],
        ]); Pjax::end();
    ?>
</div>