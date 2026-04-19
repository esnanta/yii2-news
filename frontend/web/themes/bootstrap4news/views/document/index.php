<?php

use common\helpers\MetaHelper;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\DocumentSearch $searchModel
 */

$this->title = Yii::t('frontend', 'Documents');
$this->params['breadcrumbs'][] = $this->title;
MetaHelper::setMetaTags();
?>

<div class="document-index">
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <div class="row">
        <?php echo ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'emptyText' => '<div class="col-md-12"><div class="alert alert-info">' . Yii::t('frontend', 'No documents found.') . '</div></div>',
            'options' => [
                'tag' => 'div',
                'class' => 'col-md-12',
            ],
            'itemOptions' => [
                'tag' => false, // Item view (_index_call_action) already has its own wrapping div
            ],
            'pager' => [
                'prevPageLabel' => '<i class="fa fa-angle-left g-mr-5"></i> ' . Yii::t('frontend', 'Previous'),
                'nextPageLabel' => Yii::t('frontend', 'Next') . ' <i class="fa fa-angle-right g-mr-5"></i>',
                'maxButtonCount' => 10,
                'options' => [
                    'tag' => 'nav',
                    'class' => 'text-center',
                    'aria-label' => 'Page Navigation',
                ],
                'linkContainerOptions' => [
                    'tag' => 'li',
                    'class' => 'list-inline-item',
                ],
                'linkOptions' => ['class' => 'u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14'],
                'activePageCssClass' => 'u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14',
                'disabledPageCssClass' => 'u-pagination-v1__item u-pagination-v1-4 g-brd-gray-light-v3 g-rounded-50 g-pa-7-16',
                'prevPageCssClass' => 'float-left g-rounded-50 g-pa-7-14',
                'nextPageCssClass' => 'float-right g-rounded-50 g-pa-7-14',
            ],
            'itemView' => '_index_call_action',
        ]); ?>
    </div>
</div>
