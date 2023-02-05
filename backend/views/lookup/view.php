<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Lookup $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lookups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-view">

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
            'title',
            [
                'attribute'=>'token',
                'type'=>DetailView::INPUT_HIDDEN,
            ],       
            [
                'attribute'=>'category',
                'type'=>DetailView::INPUT_HIDDEN,
            ],               
            'sequence',
            [
                'attribute'=>'editable', 
                'value'=>($model->editable==0) ? 'No':'Yes',
                //'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'type'=>DetailView::INPUT_HIDDEN, 
                'options' => ['id' => 'id', 'prompt' => ''],
                'items' => $yesNoList,
                'widgetOptions'=>[
                    'data'=>$yesNoList,
                ]                
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
        'enableEditMode' => Yii::$app->user->can('update-lookup'),
    ]) ?>

</div>
