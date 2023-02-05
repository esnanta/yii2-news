<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Outlet */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Outlet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlet-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Outlet' ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Create', ['/enrolment/select','module'=>'outlet'], ['class' => 'btn btn-primary']) ?>
            <?=
             Html::a('<i class="glyphicon glyphicon-hand-up"></i> ' . 'PDF',
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]
            )?>

            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <?= DetailView::widget([
            'model' => $model,
            'condensed' => false,
            'hover' => true,
            'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel' => [
                'heading' => '<i class="glyphicon glyphicon-info-sign"></i> Master',
                'type' => DetailView::TYPE_PRIMARY,
            ],
            'attributes' => [

                [
                    'columns' => [
                        [
                            'attribute'=>'assembly_type',
                            'format'=>'html',
                            'value'=>($model->assembly_type!=null) ? $model->getOneAssemblyType($model->assembly_type) :'',
                            'type'=>DetailView::INPUT_DROPDOWN_LIST,
                            'options' => ['id' => 'assembly_type', 'prompt' => ''],
                            'items' => $assemblyTypeList,
                            'widgetOptions'=>[
                                'data'=>$assemblyTypeList,
                            ],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'billing_status',
                            'label' => 'Billed',
                            'format'=>'html',
                            'value'=>(!empty($model->billing_status)) ? $model->getOneBillingStatus($model->billing_status):'',
                            'type'=>DetailView::INPUT_DROPDOWN_LIST,
                            'options' => ['id' => 'billing_status', 'prompt' => ''],
                            'items' => $billingStatusList,
                            'widgetOptions'=>[
                                'data'=>$billingStatusList,
                            ],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'description',
                            'format'=>'html',
                            'type'=>DetailView::INPUT_TEXTAREA,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute' => 'claim',
                            'label' => 'Claim',
                            'format' => ['decimal'],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],

                [
                    'group'=>true,
                    'rowOptions'=>['class'=>'default']
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'customer_id',
                            'value'=>($model->customer_id!=null) ? Html::a($model->customer->title, $model->customer->getUrl()):'',
                            'format'=>'html',
                            'type'=>DetailView::INPUT_DROPDOWN_LIST,
                            'options' => ['id' => 'customer_id', 'prompt' => ''],
                            'items' => $customerList,
                            'widgetOptions'=>[
                                'data'=>$customerList,
                            ],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'staff_id',
                            'value'=>($model->staff_id!=null) ? Html::a($model->staff->title, $model->staff->getUrl()):'',
                            'format'=>'html',
                            'type'=>DetailView::INPUT_DROPDOWN_LIST,
                            'options' => ['id' => 'staff_id', 'prompt' => ''],
                            'items' => $staffList,
                            'widgetOptions'=>[
                                'data'=>$staffList,
                            ],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'title',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'invoice',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],


                [
                    'columns' => [
                        [
                            'attribute'=>'date_issued',
                            'format'=>'date',
                            'type'=>DetailView::INPUT_WIDGET,
                            'widgetOptions'=>[
                                'class'=>DateControl::classname(),
                                'type'=>DateControl::FORMAT_DATE,
                            ],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'date_assembly',
                            'format'=>'date',
                            'type'=>DetailView::INPUT_WIDGET,
                            'widgetOptions'=>[
                                'class'=>DateControl::classname(),
                                'type'=>DateControl::FORMAT_DATE,
                            ],
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],

                [
                    'group'=>true,
                    'rowOptions'=>['class'=>'default']
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'created_at',
                            'format'=>'date',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'updated_at',
                            'format'=>'date',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'created_by',
                            'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'updated_by',
                            'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],

            ],
            'deleteOptions' => [
                'url' => ['delete', 'id' => $model->id],
            ],
            'enableEditMode' => false,
        ]) ?>


        <?php
            if($providerOutletDetail->totalCount){
                Pjax::begin(); echo GridView::widget([
                    'dataProvider' => $providerOutletDetail,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'invoice',
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'180px',
                            'value'=>function ($model, $key, $index, $widget) {
                                return ($model->id!=null) ? $model->outlet->invoice:'';
                            },
                        ],
                        [
                            'attribute'=>'assembly_cost',
                            'format'=>'decimal',
                        ],
                        [
                            'attribute'=>'monthly_bill',
                            'format'=>'decimal',
                        ],
                        [
                            'attribute'=>'device_type',
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'180px',
                            'value'=>function ($model, $key, $index, $widget) {
                                return ($model->device_type!=null) ? $model->getOneDeviceType($model->device_type):'';
                            },
                        ],
                        [
                            'attribute'=>'device_status',
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'180px',
                            'value'=>function ($model, $key, $index, $widget) {
                                return ($model->device_status!=null) ? $model->getOneDeviceStatus($model->device_status):'';
                            },
                        ],

                        'description'

                    ],
                    'responsive' => true,
                    'hover' => true,
                    'condensed' => true,
                    'floatHeader' => true,

                    'panel' => [
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> Detail </h3>',
                        'type' => 'primary',
                        'showFooter' => false
                    ],
                ]); Pjax::end();
            }
        ?>
        </div>
        <div class="col-md-3">
            <?=
                $this->render('/customer/side_view',[
                    'customer'=>$customer,
                    'enrolment'=>$enrolment,
                ]);
            ?>
        </div>
    </div>
</div>
