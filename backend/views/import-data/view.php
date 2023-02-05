<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\ImportData */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Import Data', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-data-view">

    <div class="row">
        <div class="col-sm-10">
            <h2><?= 'Import Data'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-2" style="margin-top: 15px">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php //Html::a('Duplicate', ['duplicate', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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


    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                Please specify range of row data to export         
            </div>
        </div>
        <div class="panel-body">

            <div class="view-create">

                <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>

                <?= $form->errorSummary($model); ?>

                <?php
                    echo Form::widget([

                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        'attributes' => [
                            
                            'row_start' => [
                                'type' => Form::INPUT_WIDGET, 
                                'widgetClass'=> Select2::className(),
                                'options' => [
                                    'data' => $firstRange,
                                    'options' => ['placeholder' => 'Choose option', 'disabled'=>false],
                                ],                            
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],                            
                            ],                            
                            
                            'row_end' => [
                                'type' => Form::INPUT_WIDGET, 
                                'widgetClass'=> Select2::className(),
                                'options' => [
                                    'data' => $lastRange,
                                    'options' => ['placeholder' => 'Choose option', 'disabled'=>false],
                                ],                            
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],                            
                            ], 
                            
                            //'row_start' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Row Start...']],
                            //'row_end' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Row End...']],
                        ]

                    ]);
                ?>
                <?= Html::submitButton('Execute', ['class' => 'btn btn-warning' ]) ?> 

                <?php ActiveForm::end(); ?>

            </div>

        </div>
    </div>    
    

    
    
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_PRIMARY,
        ],
        'attributes' => [

            [
                'attribute'=>'modul_type', 
                'value'=>($model->modul_type!=null) ? $model->getOneModule($model->modul_type):'',              
            ],             

            'title',
            'row_start',
            'row_end',
            [
                'attribute'=>'description', 
                'format'=>'html',
            ],          
            'file_name',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]) ?>         
    
    <?php
        if($providerImportAttribute->totalCount){
            $gridColumnImportAttribute = [
                ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    'title',
                    'column_index',
        
                    [
                        'attribute' => 'conversion',
                        'value' => function ($data) {
                            return $data->getOneConversion($data->conversion); // $data['name'] for array data, e.g. using SqlDataProvider.
                        },
                    ],

                    'description:ntext',
                    ['attribute' => 'verlock', 'visible' => false],
            ];
            echo Gridview::widget([
                'dataProvider' => $providerImportAttribute,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tx-import-attribute']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Attributes'),
                ],
                'export' => false,
                'columns' => $gridColumnImportAttribute
            ]);
        }
    ?>


</div>
