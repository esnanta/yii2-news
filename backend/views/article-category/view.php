<?php

use common\helper\UIHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;
/**
 * @var yii\web\View $this
 * @var common\models\ArticleCategory $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = UIHelper::getCreateButton();
?>
<div class="category-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            'title',
            'sequence',
            //'label',
            [
                'attribute'=>'label', 
                'value'=>($model->label!=null) ? $model->label:'',
                'type'=>DetailView::INPUT_SELECT2, 
                'options' => ['id' => 'label', 'prompt' => '', 'disabled'=>false],
                'items' => $labelList,
                'widgetOptions'=>[
                    'class'=> Select2::class,
                    'data'=>$labelList,
                ],
            ],
            [
                'attribute'=>'time_line',
                'format'=>'html',
                'value'=>(!empty($model->time_line)) ? $model->getOneTimeLine($model->time_line):'',
                'type'=>DetailView::INPUT_SELECT2,
                'options' => ['id' => 'time_line', 'prompt' => '', 'disabled'=>false],
                'items' => $dataList,
                'widgetOptions'=>[
                    'class'=> Select2::class,
                    'data'=>$dataList,
                ],
            ],
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
        'enableEditMode' => Yii::$app->user->can('update-articlecategory'),
    ]) ?>

</div>
