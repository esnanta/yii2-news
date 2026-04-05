<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\StaffSearch $searchModel
 */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

$col = 'col-md-4';
$countData = $dataProvider->getTotalCount();

if ($countData == 2) {
    $col = 'col-md-4 offset-md-2';
} elseif ($countData >= 3) {
    $col = 'col-md-4';
}
?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'emptyText' => 'No staff found.',
        'options' => [
            'tag' => 'div',
            'class' => 'row',
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => $col . ' mb-4',
        ],
        'pager' => [
            'prevPageLabel' => '<i class="fa fa-angle-left"></i> Previous',
            'nextPageLabel' => 'Next <i class="fa fa-angle-right"></i>',
            'maxButtonCount' => 5,
            'options' => [
                'tag' => 'nav',
                'class' => 'pagination justify-content-center mt-4',
                'aria-label' => 'Page Navigation'
            ],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
        ],
        'itemView' => '_index_feature',
    ]); ?>
