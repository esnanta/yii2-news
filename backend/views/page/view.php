<?php

use common\models\Page;
use kartik\editors\Summernote;
use kartik\detail\DetailView;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Page $model
 * @var common\models\Page $pageTypeList
 */

$this->title = $model->title;
$labelBreadcrumbs = 'Pages ('.strip_tags($model->getOnePageType($model->page_type)).')';
$this->params['breadcrumbs'][] = ['label' => $labelBreadcrumbs, 'url' => ['index', 'type' => $model->page_type]];
$this->params['breadcrumbs'][] = $this->title;

$emptyContent = '<span class=float-end>'.$model->getEmptyContentUrl().'</span>';
?>

<div class="page-view">
    <?php
    echo DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
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
                'value' => $emptyContent.$model->content,
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => Summernote::class
                ],
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-page'),
    ]);
    ?>
</div>
