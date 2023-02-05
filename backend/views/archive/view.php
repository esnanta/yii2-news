<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var backend\models\Archive $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);

$deleteAsset = Html::a('<i class="fa fa-trash"></i> Delete File', ['archive/delete-file','id' => $model->id],
                    ['class' => 'pull-right', 'data-confirm' => "Delete Asset?", 
                    'data-method' => 'POST', 'title' => 'Delete Asset?']);
?>

<div class="archive-view">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Arsip</h3>
                    <span class="pull pull-right">
                        <i class="fa fa-eye"></i> <?=$model->view_counter;?> &nbsp;
                        <i class="fa fa-download"></i> <?=$model->download_counter;?>
                    </span>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php 
                        if($model->getAssetFile()){
                            echo Html::a('DOWNLOAD FILE', 
                                    ['archive/download','id'=>$model->id,'title'=>$model->title],
                                    ['title'=>'Download']);
                        }
                    ?>

                    <?php
                        if(!empty($model->file_name)){
                            echo $deleteAsset;

                            $assetUrl   = $model->getAssetUrl();
                            $tmp        = explode('.', $model->asset);
                            $ext        = end($tmp);

                            if($ext=='jpg'||$ext=='jpeg'||$ext=='png'||$ext=='gif'){
                                echo Html::img(str_replace('frontend', 'backend', $assetUrl), ['class' => 'img-fluid']);
                    ?>

                    <?php
                            } else {
                                echo \lesha724\documentviewer\ViewerJsDocumentViewer::widget([
                                    'url'=> $assetUrl,//url на ваш документ
                                    //'url'=> 'www.hubunganinternasional.id/main/admin/uploads/archive/sA9CMQGWN_JbpSHqt2lsIrMLkc9Cxfl6.docx',//url на ваш документ
                                    'width'=>'100%',
                                    'height'=>'300px',
                                    //https://geektimes.ru/post/111647/
                                ]);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
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
                        'attribute'=>'date_issued',
                        'format'=>'date',
                        'type'=>DetailView::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class'=>DateControl::classname(),
                            'type'=>DateControl::FORMAT_DATE,
                        ],
                    ],
                    [
                        'attribute'=>'is_visible',
                        'format'=>'html',
                        'value'=>($model->is_visible!=null) ? $model->getOneIsVisible($model->is_visible):'',
                        'type'=>DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'is_visible', 'prompt' => '', 'disabled'=>false],
                        'items' => $isVisibleList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$isVisibleList,
                        ],
                        //'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute'=>'archive_category_id', 
                        'value'=>($model->archive_category_id!=null) ? $model->archiveCategory->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'archive_category_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $archiveCategoryList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$archiveCategoryList,
                        ],
                    ],  
                    [
                        'attribute'=>'title', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXT, 
                    ], 
                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'value'=>$model->description,
                        'type'=>DetailView::INPUT_WIDGET, 
                        'widgetOptions'=>[
                            'class'=> CKEditor::className(),
                            'editorOptions' => [
                                'preset' => 'basic', // basic, standard, full
                                'inline' => false,
                            ],                      
                        ],              
                    ],
                    
                    [
                        'attribute' => 'asset',
                        'label' => 'Asset Url',
                        'value' => 'https://'.Yii::$app->getRequest()->serverName.$model->getAssetUrl(),
                        'format' => 'raw',

                        'type'=>DetailView::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class'=> FileInput::classname(),
                            'pluginOptions'=>['previewFileType' => 'any','showUpload' => false,]
                        ],
                        //'valueColOptions'=>['style'=>'width:30%']
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
                'enableEditMode' => true,
            ]) ?>
        </div>
    </div>

</div>
