<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\EnrolmentSearch $searchModel
 */

$this->title = 'Enrolments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enrolment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Enrolment', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'title',
            
            [
                'attribute' => 'customer_title',
                'label' => 'Customer',
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
                'label' => 'No Telpon',
                'format'=>'html',
                'value' => function($model){
                    if ($model->customer_id)
                    {return $model->customer->phone_number;}
                    else
                    {return NULL;}
                },
            ],
                        
//            [
//                'attribute' => 'customer_number',
//                'label' => 'Nomor',
//                'format'=>'html',
//                'value' => function($model){
//                    if ($model->customer_id)
//                    {return Html::a($model->enrolment->title, $model->enrolment->getUrl());}
//                    else
//                    {return NULL;}
//                },
//            ],
//            [
//                'attribute'=>'network_id',
//                'vAlign'=>'middle',
//                'width'=>'180px',
//                'value'=>function ($model, $key, $index, $widget) {
//                    return ($model->network_id!=null) ? $model->network->title:'';
//                },
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>$networkList,
//                'filterWidgetOptions'=>[
//                    'pluginOptions'=>['allowClear'=>true],
//                ],
//                'filterInputOptions'=>['placeholder'=>''],
//                'format'=>'raw'
//            ],
            [
                'attribute'=>'billing_cycle',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) {
                    return ($model->billing_cycle!=null) ? $model->billing_cycle:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$billingCycleList,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
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
                'attribute'=>'enrolment_type',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) use ($module) {
                    
                    $link='';
                    
                    if($module=='service'){
                        $link = ($model->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_ANALOG) ?
                                Html::a('<i class="fa fa-cloud-upload"></i>',
                                        Yii::$app->urlManager->createUrl([$module.'/create', 
                                            'id' => $model->customer_id,
                                            'type' => backend\models\Service::SERVICE_TYPE_CHANGE_TO_DIGITAL,
                                            'title' => 'Update Digital']),
                                [
                                    'title' => Yii::t('yii', 'Update Digital'),
                                    'class'=>'btn btn-sm btn-success',
                                ])
                                
                                :
                            
                                '';
//                                Html::a('+1', Yii::$app->urlManager->createUrl(['/service/create',
//                                    'id'=>$model->customer_id,
//                                    'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
//                                    'title' => 'Extend',
//                                    'days'=>'30 day']),
//                                        [
//                                            'title' => Yii::t('yii', '+1 bulan'),
//                                            'class'=>'btn btn-sm btn-info',             
//                                        ]
//                                ).' '.
//                                Html::a('+2', Yii::$app->urlManager->createUrl(['/service/create',
//                                    'id'=>$model->customer_id,
//                                    'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
//                                    'title' => 'Extend',
//                                    'days'=>'60 day']),
//                                        [
//                                            'title' => Yii::t('yii', '+2 bulan'),
//                                            'class'=>'btn btn-sm btn-primary',             
//                                        ]
//                                ).' '.
//                                Html::a('+3', Yii::$app->urlManager->createUrl(['/service/create',
//                                    'id'=>$model->customer_id,
//                                    'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
//                                    'title' => 'Extend',
//                                    'days'=>'90 day']),
//                                        [
//                                            'title' => Yii::t('yii', '+3 bulan'),
//                                            'class'=>'btn btn-sm btn-success',             
//                                        ]
//                                );                        
                    }

                    return ($model->enrolment_type!=null) ? $model->getOneEnrolmentType($model->enrolment_type).' <span class="pull pull-right">'.$link.'</span>':'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$enrolmentTypeList,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],
            [
                'label' => ucfirst($module),
                'vAlign'=>'middle',
                'width'=>'120px',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
                'value'=> function ($model) use ($module)  {
                    return
                            ($model->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_ANALOG) ?
                                //LINK UNTUK ANALOG ADALAH TETAP
                                //FORM NYA TIDAK ADA JENIS, TGL MULAI, TGL AKHIR
                                Html::a('<i class="fa fa-refresh"></i>',
                                        Yii::$app->urlManager->createUrl([$module.'/create', 
                                            'id' => $model->customer_id,
                                            'type' => backend\models\Service::SERVICE_TYPE_GENERAL,
                                            'title' => 'Analog']),
                                [
                                    'title' => Yii::t('yii', 'Analog'),
                                    'class'=>'btn btn-sm btn-danger',
                                ])
                            :
                                //KEADAAN SUDAH DIGITAL. JADI = EXTEND/PERPANJANG
                                //FORM NYA ADA JENIS, TGL MULAI, TGL AKHIR
                                Html::a('<i class="fa fa-refresh"></i>',
                                        Yii::$app->urlManager->createUrl([$module.'/create', 
                                            'id' => $model->customer_id,
                                            'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
                                            'title' => 'Extend']),
                                [
                                    'title' => Yii::t('yii', 'Digital'),
                                    'class'=>'btn btn-sm btn-primary',
                                ]);
                },
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> Select '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['/customer/select','module'=>'enrolment'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
