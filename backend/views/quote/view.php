<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var common\models\Quote $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Quotes', 'url' => ['index']];
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
                    <?= Html::a($model->title, ['/quote/update', 'id' => $model->id,]); ?>
                </h3>

                <p class="text-muted text-center">Quote Section</p>           

                <strong><i class="fa fa-info-circle margin-r-5"></i> Source</strong>

                <p class="text-muted">
                    <?= $model->source; ?>
                </p>                

                <strong><i class="fa fa-book margin-r-5"></i> Deskripsi</strong>

                <p class="text-muted">
                    <?= $model->description; ?>
                </p>       
                
                <?= Html::a('Change Avatar', ['/quote/update', 'id' => $model->id, 'edit' => 't'], ['class' => 'btn btn-primary btn-block']); ?>
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
                        'buttons1' => '{update}',
                        'attributes' => [
                            'title',
                            'source',
                            [
                                'attribute'=>'content', 
                                'format'=>'html',
                                'value'=>$model->content,
                                'type'=>DetailView::INPUT_WIDGET, 
                                'widgetOptions'=>[
                                    'class'=> CKEditor::class,
                                    'editorOptions' => [
                                        'preset' => 'basic', // basic, standard, full
                                        'inline' => false,
                                    ],                      
                                ],              
                            ],       
                            [
                                'attribute'=>'description', 
                                'format'=>'html',
                                'type'=>DetailView::INPUT_TEXTAREA,                    
                            ],                              
                        ],
                        'deleteOptions' => [
                            'url' => ['delete', 'id' => $model->id],
                        ],
                        'enableEditMode' => Yii::$app->user->can('update-quote'),
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



<div class="quote-view">



</div>
