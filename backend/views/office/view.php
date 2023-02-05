<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Office $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [

                'attribute'=>'title', 

                'valueColOptions'=>['class'=>'pull-left','style'=>'width:38%']
            ],     
            [
                'columns' => [
                    [
                        'attribute'=>'phone_number', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'fax_number', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],    
                ],
            ], 
            [
                'columns' => [
                    [
                        'attribute'=>'email', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'web', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],    
                ],
            ],             
            [
                'columns' => [
                    [
                        'attribute'=>'google_plus', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'facebook', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],    
                ],
            ], 
            [
                'columns' => [
                    [
                        'attribute'=>'instagram', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'twitter', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],    
                ],
            ], 
            [
                'columns' => [
                    [
                        'attribute'=>'latitude', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'longitude', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],    
                ],
            ], 
            [
                'columns' => [
                    [
                        'attribute'=>'address', 
                        'type'=>DetailView::INPUT_TEXTAREA,  
                        'valueColOptions'=>['style'=>'width:30%']
                    ],     
                    [
                        'attribute'=>'description', 
                        'type'=>DetailView::INPUT_TEXTAREA,  
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
        'enableEditMode' => Yii::$app->user->can('update-office'),
    ]) ?>

</div>
