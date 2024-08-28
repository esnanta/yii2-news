<?php

use common\helper\LabelHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use bajadev\ckeditor\CKEditor;

/**
 * @var yii\web\View $this
 * @var common\models\Asset $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = LabelHelper::getCreateButton();

$deleteAsset = Html::a('<i class="fa fa-trash"></i> Delete File', ['asset/delete-file','id' => $model->id],
                    ['class' => 'float-right', 'data-confirm' => "Delete Asset?", 
                    'data-method' => 'POST', 'title' => 'Delete Asset?']);
?>

<div class="asset-view">
    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">
                        <i class="fa fa-eye"></i> <?=$model->view_counter;?>
                        <?php
                            echo Html::a('<i class="fas fa-download"></i> '.$model->download_counter,
                                ['asset/download','id'=>$model->id,'title'=>$model->title],
                                ['class'=>'card-link','title'=>'Download']);

                            if($isSpreadsheet == 'Xlsx') {
                                echo Html::a('<i class="fas fa-file-import"></i> Import',
                                    ['participant/import', 'id' => $model->id, 'title' => $model->title],
                                    ['class' => 'card-link', 'title' => 'Import']);
                            }

                            if(!empty($model->asset_name)) {
                                echo Html::a('<i class="fas fa-trash"></i>', ['asset/delete-file', 'id' => $model->id],
                                    ['class' => 'card-link float-right', 'data-confirm' => "Delete Asset?",
                                        'data-method' => 'POST', 'title' => 'Delete Asset?']);
                            }
                        ?>
                    </h6>

                    <p class="card-text">

                        <?php

                            $assetUrl   = $model->getAssetUrl();
                            $tmp        = explode('.', $model->asset);
                            $ext        = end($tmp);

                            if($ext=='jpg'||$ext=='jpeg'||$ext=='png'||$ext=='gif'){
                                echo Html::img(str_replace('frontend', 'backend', $assetUrl), ['class' => 'img-fluid']);
                            } elseif ($isSpreadsheet == 'Xlsx'){
                                echo $helper->displayGrid($sheetData);
                            } else {
                                echo \lesha724\documentviewer\ViewerJsDocumentViewer::widget([
                                    'url'=> $assetUrl,//url на ваш документ
                                    //'url'=> 'www.hubunganinternasional.id/main/admin/uploads/archive/sA9CMQGWN_JbpSHqt2lsIrMLkc9Cxfl6.docx',//url на ваш документ
                                    'width'=>'100%',
                                    'height'=>'300px',
                                    //https://geektimes.ru/post/111647/
                                ]);
                            }

                        ?>
                    </p>

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
                    'type' => DetailView::TYPE_DEFAULT,
                ],
                'attributes' => [
                    [
                        'attribute'=>'date_issued',
                        'format'=>'date',
                        'type'=>DetailView::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class'=>DateControl::class,
                            'type'=>DateControl::FORMAT_DATE,
                        ],
                    ],
                    [
                        'attribute'=>'title', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXT, 
                    ],
                    [
                        'attribute'=>'asset_category_id',
                        'value'=>($model->asset_category_id!=null) ? $model->assetCategory->title:'',
                        'type'=>DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'asset_category_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $assetCategoryList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$assetCategoryList,
                        ],
                    ],
                    [
                        'attribute'=>'asset_type',
                        'format'=>'html',
                        'value'=>($model->asset_type!=null) ? $model->getOneAssetType($model->asset_type):'',
                        'type'=>DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'asset_type', 'prompt' => '', 'disabled'=>false],
                        'items' => $assetTypeList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$assetTypeList,
                        ],
                        //'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute'=>'is_visible',
                        'format'=>'html',
                        'value'=>($model->is_visible!=null) ? $model->getOneIsVisible($model->is_visible):'',
                        'type'=>DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'is_visible', 'prompt' => '', 'disabled'=>false],
                        'items' => $isVisibleList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$isVisibleList,
                        ],
                        //'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'value'=>$model->description,
                        'type'=>DetailView::INPUT_TEXTAREA,
                    ],
                    
                    [
                        'attribute' => 'asset',
                        'label' => 'Asset Url',
                        'value' => 'https://'.Yii::$app->getRequest()->serverName.$model->getAssetUrl(),
                        'format' => 'raw',

                        'type'=>DetailView::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class'=> FileInput::class,
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
                                'value'=>($model->created_by!=null) ? \common\models\User::getName($model->created_by):'',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'updated_by',
                                'value'=>($model->updated_by!=null) ? \common\models\User::getName($model->updated_by):'',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],
                ],
                'deleteOptions' => [
                    'url' => ['delete', 'id' => $model->id],
                ],
                'enableEditMode' => Yii::$app->user->can('update-asset'),
            ]) ?>
        </div>
    </div>

</div>
