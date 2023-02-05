<?php
use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Album $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create     = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], 
                        ['class' => 'pull-right detail-button','style'=>'padding:0 5px', 'title' => 'New Album']);
$addPhoto   = Html::a('<i class="glyphicon glyphicon-picture"></i>', ['photo/create','id'=>$model->id], 
                        ['class' => 'pull-right detail-button','style'=>'padding:0 5px', 'title' => 'Add Photo']);
?>
<div class="album-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create.$addPhoto,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [
                'attribute' => 'cover',
                'format' => ['image',['width'=>'150','height'=>'100']],
                'type'=>DetailView::INPUT_HIDDEN,          
            ],             
            [
                'attribute'=>'album_type', 
                'format'=>'html',
                'value'=>($model->album_type!=null) ? $model->getOneAlbumType($model->album_type):'',
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'album_type', 'prompt' => ''],
                'items' => $dataList,
                'widgetOptions'=>[
                    'data'=>$dataList,
                ]                
            ],              
            'title',
            [
                'attribute'=>'description', 
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,                    
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
        'enableEditMode' => Yii::$app->user->can('update-album'),
    ]) ?>

</div>


<div class="row">
    <?php
        foreach ($photos as $i => $photoModel) {
    ?>
            <div class="col-sm-3 margin-bottom">

                <div class="box box-widget">
                    <div class="box-body">                    
                        <div class="btn-group pull-right">
                            <?=
                                Html::a('<i class="fa fa-refresh"></i>', ['cover','id'=>$photoModel->id, 'title'=>$photoModel->title],
                                        ['class'=>'btn btn-default', 'title' => 'Set As Album Cover']);
                            ?>
                            <?=
                                Html::a('<i class="fa fa-eye"></i>', ['photo/view','id'=>$photoModel->id, 'title'=>$photoModel->title],
                                        ['class'=>'btn btn-default', 'title' => 'View Photo']);
                            ?>
                            <?=             
                                Html::a('<i class="glyphicon glyphicon-trash"></i>', 
                                    ['album/remove','id'=>$photoModel->id],
                                    [
                                        'class'=>'btn btn-default',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete Photo',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this image?',
                                            'method' => 'post',
                                        ],                                                
                                    ]
                                );
                            ?>                             
                        </div>
                        
                        <br>
                        
                        <?=Html::img($photoModel->getImageUrl(), ['class'=>'img-responsive','style'=>'height:150px']);?>
                        
                    </div>
                </div>                    

            </div>        
    <?php
        }
    ?>        
</div>