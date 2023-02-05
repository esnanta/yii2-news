<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\ValidityDetail $model
 */

$this->title = 'Validasi '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Validity Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/enrolment/select','module'=>'validity-detail'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);

$isDisabled = (Yii::$app->user->identity->isAdmin) ? false : true;
?>
<div class="validity-detail-view">
    <div class="row">
        <div class="col-md-9">
            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => $this->title.$create,
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [

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
                                'options' => ['id' => 'customer_id', 'prompt' => '' , 'disabled'=>true],
                                'items' => $customerList,
                                'widgetOptions'=>[
                                    'data'=>$customerList,
                                ],
                                'valueColOptions'=>['style'=>'width:30%']
                            ],                                     
                            [
                                'attribute'=>'device_status', 
                                'value'=>(!empty($model->device_status)) ? $model->getOneDeviceStatus($model->device_status):'',
                                'format'=>'html',
                                'type'=>DetailView::INPUT_SELECT2, 
                                'options' => ['id' => 'device_status', 'prompt' => '', 'disabled'=>$isDisabled],
                                'items' => $deviceStatusList,
                                'widgetOptions'=>[
                                    'class'=> Select2::className(),
                                    'data'=>$deviceStatusList,
                                ],
                                'valueColOptions'=>['style'=>'width:30%']
                            ],                            
                        ],
                    ],  

                    [
                        'columns' => [
                            
                            [
                                'attribute'=>'date_due', 
                                'format'=>'date',
                                'type'=>DetailView::INPUT_WIDGET,             
                                'widgetOptions'=>[
                                    'class'=>DateControl::classname(),
                                    'type'=>DateControl::FORMAT_DATE,  
                                ],
                                'valueColOptions'=>['style'=>'width:30%']
                            ],  

                            [
                                'attribute'=>'billing_status', 
                                'value'=>(!empty($model->billing_status)) ? $model->getOneBillingStatus($model->billing_status):'',
                                'format'=>'html',
                                'type'=>DetailView::INPUT_SELECT2, 
                                'options' => ['id' => 'billing_status', 'prompt' => '', 'disabled'=>$isDisabled],
                                'items' => $billingStatusList,
                                'widgetOptions'=>[
                                    'class'=> Select2::className(),
                                    'data'=>$billingStatusList,
                                ],
                                'valueColOptions'=>['style'=>'width:30%']
                            ],      



                        ],
                    ],                     
                    
                    [
                        'columns' => [
                            [
                                'attribute' => 'month_period',
                                'type'=>DetailView::INPUT_TEXT,  
                                'options' => ['disabled'=>true],
                                'valueColOptions'=>['style'=>'width:30%']
                            ],                           
                            [
                                'attribute' => 'amount',
                                'options' => ['id' => 'billing_status', 'prompt' => '', 'disabled'=>$isDisabled],
                                'type'=>DetailView::INPUT_TEXT,  
                                'valueColOptions'=>['style'=>'width:30%']
                            ],                                                        
                        ],
                     
                    ],                    


                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXTAREA,
                        'inputContainer' => ['class'=>'col-sm-6'],
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
                'enableEditMode' => Yii::$app->user->can('update-validity-detail'),
            ]) ?>
        </div>
        <div class="col-md-3">
            <?=$this->render('/customer/side_view',[
                'customer'=>null,
                'enrolment'=>$enrolment,
            ])
            ?>               
        </div>
    </div>
            

</div>
