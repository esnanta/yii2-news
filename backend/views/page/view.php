<?php

use kartik\editors\Summernote;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use common\models\Page;

/**
 * @var yii\web\View $this
 * @var common\models\Page $model
 */

$this->title = $model->title;
$labelBreadcrumbs = 'Pages ('.strip_tags($model->getOnePageType($model->page_type)).')';
$this->params['breadcrumbs'][] = ['label' => $labelBreadcrumbs, 'url' => ['index', 'type' => $model->page_type]];
$this->params['breadcrumbs'][] = $this->title;

$update = Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'button pull-right', 'style' => 'color:#333333;padding:0 5px']);
?>

<div class="page-view">
    <?php
    echo DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title . $update,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            [
                'attribute' => 'description',
                'format' => 'html',
                'type' => DetailView::INPUT_TEXTAREA,
                'displayOnly' => !Yii::$app->user->identity->isAdmin,
            ],
            [
                'attribute' => 'page_type',
                'value' => ($model->page_type != null) ? $model->getOnePageType($model->page_type) : '',
                'format' => 'html',
                'type' => DetailView::INPUT_SELECT2,
                'options' => ['id' => 'page_type', 'prompt' => '', 'disabled' => false],
                'items' => $pageTypeList,
                'widgetOptions' => [
                    'class' => Select2::class,
                    'data' => $pageTypeList,
                ],
            ],
            'title',
            [
                'attribute' => 'content',
                'format' => ($model->page_type != Page::PAGE_TYPE_IMAGE) ? 'html':'raw',
                'value' => $model->content,
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => Summernote::class
                ],
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]);
    ?>
</div>
