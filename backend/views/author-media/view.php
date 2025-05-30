<?php

use common\helper\IconHelper;
use common\helper\LabelHelper;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\AuthorMedia $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->author->title,
    'url' => ['author/view','id'=>$model->author_id]];$this->params['breadcrumbs'][] = $this->title;

$route = ['author-media/create','author'=>$model->id,'type'=>$model->media_type];
$create = LabelHelper::getCreateButton($route);
?>
<div class="author-media-view">

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
            [
                'attribute' => 'office_id',
                'value' => ($model->office_id != null) ? $model->office->title : '',
                'type' => DetailView::INPUT_SELECT2,
                'options' => ['id' => 'office_id', 'prompt' => '', 'disabled' => (Yii::$app->user->identity->isAdmin) ? false : true],
                'items' => $officeList,
                'widgetOptions' => [
                    'class' => Select2::class,
                    'data' => $officeList,
                ],
            ],
            [
                'attribute'=>'title',
                'format'=>'html',
                'value'=> ($model->title!=null) ? IconHelper::getFontAwesomeBrandValue($model->title) : '',
                'type'=>DetailView::INPUT_SELECT2,
                'options' => ['id' => 'is_visible', 'prompt' => '', 'disabled'=>false],
                'items' => IconHelper::getFontAwesomeBrands(),
                'widgetOptions'=>[
                    'class'=> Select2::class,
                    'data'=> IconHelper::getFontAwesomeBrands(),
                ],
                //'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('app', 'Url Link'),
                'type' => DetailView::INPUT_TEXTAREA,
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'created_at',
                        'format' => 'date',
                        'type' => DetailView::INPUT_HIDDEN,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'date',
                        'type' => DetailView::INPUT_HIDDEN,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'created_by',
                        'value' => ($model->created_by != null) ? \common\models\User::getName($model->created_by) : '',
                        'type' => DetailView::INPUT_HIDDEN,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'updated_by',
                        'value' => ($model->updated_by != null) ? \common\models\User::getName($model->updated_by) : '',
                        'type' => DetailView::INPUT_HIDDEN,
                        'valueColOptions' => ['style' => 'width:30%']
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
