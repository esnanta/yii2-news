<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\Staff $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>



<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-md-6">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img src="<?= $model->getImageUrl() ?>" class="profile-user-img img-responsive img-circle" style="width:100px;height:100px" alt="<?= $model->title; ?>"/>

                <h3 class="profile-username text-center">
                    <?= Html::a($model->title, ['/staff/update', 'id' => $model->id,]); ?>
                </h3>

                <p class="text-muted text-center"><?= (!empty($model->email)) ? $model->email:'-' ?></p>

                <strong><i class="fa fa-info-circle margin-r-5"></i> Inisial</strong>

                <p class="text-muted">
                    <?= (!empty($model->initial)) ? $model->initial:'-'; ?>
                </p>                   

                <strong><i class="fa fa-phone margin-r-5"></i> Telpon</strong>

                <p class="text-muted">
                    <?= (!empty($model->phone_number)) ? $model->phone_number:'-'; ?>
                </p>                                      
                
                <?= Html::a('Change Avatar', ['/staff/update', 'id' => $model->id, 'edit' => 't'], ['class' => 'btn btn-primary btn-block']); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->             
    </div>
    



    <div class="col-md-9">
        <div class="box box-default">
            
        
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    <?= DetailView::widget([
                        'model' => $model,
                        'condensed' => false,
                        'hover' => true,
                        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                        'panel' => [
                            'heading' => $this->title.$create,
                            'type' => DetailView::TYPE_INFO,
                        ],
                        'attributes' => [

                            [
                                'attribute'=>'title', 
                                //'valueColOptions'=>['style'=>'width:30%']
                            ],    
                            
                            [
                                'group'=>true,
                                'rowOptions'=>['class'=>'default']
                            ],  
                            
                            [
                                'columns' => [
                                    [
                                        'attribute'=>'employment_id', 
                                        'value'=>($model->employment_id!=null) ? $model->employment->title:'',
                                        'type'=>DetailView::INPUT_SELECT2, 
                                        'options' => ['id' => 'employment_id', 'prompt' => '', 'disabled'=>false],
                                        'items' => $employmentList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$employmentList,
                                        ],
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],             
                                    [
                                        'attribute'=>'active_status', 
                                        'value'=>($model->active_status!=null) ? $model->getOneActiveStatus($model->active_status) :'',
                                        'format'=>'html',
                                        'type'=>DetailView::INPUT_SELECT2, 
                                        'options' => ['id' => 'active_status', 'prompt' => '', 'disabled'=>false],
                                        'items' => $activeStatusList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$activeStatusList,
                                        ],
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],    
                                ],
                            ],            

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'phone_number', 
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                     
                                    [
                                        'attribute'=>'gender_status', 
                                        'value'=>($model->gender_status!=null) ? $model->getOneGenderStatus($model->gender_status) :'',
                                        'format'=>'html',
                                        'type'=>DetailView::INPUT_SELECT2, 
                                        'options' => ['id' => 'gender_status', 'prompt' => '', 'disabled'=>false],
                                        'items' => $genderStatusList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$genderStatusList,
                                        ],
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                                
                                ],
                            ],     

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'initial', 
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],   
                                    [
                                        'attribute'=>'email', 
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
                                        'attribute'=>'facebook', 
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                        
                                ],
                            ],            

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'twitter', 
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],   
                                    [
                                        'attribute'=>'google_plus', 
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                                                
                                ],
                            ],  
                            
                            [
                                'group'=>true,
                                'rowOptions'=>['class'=>'default']
                            ], 
                            
                            [
                                'attribute'=>'description', 
                                'format'=>'html',
                                'type'=>DetailView::INPUT_TEXTAREA,                           
                                //'valueColOptions'=>['style'=>'width:30%']
                            ],                             
                            [
                                'attribute'=>'file_name',
                                'type'=>DetailView::INPUT_HIDDEN,
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
                        'enableEditMode' => Yii::$app->user->can('update-staff'),
                    ]) ?>                   
                    
                    
                    
                    
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        </div>
        <!-- /.nav-tabs-custom -->
    </div>    
    
</div>







<div class="staff-view">



</div>
