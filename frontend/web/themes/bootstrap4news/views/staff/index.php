<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\StaffSearch $searchModel
 */

$this->title = 'Our Team';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container py-5">
    <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
            <h1 class="display-4"><?php echo Html::encode($this->title); ?></h1>
            <p class="lead text-muted">Meet our dedicated team of professionals.</p>
        </div>
    </div>

    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'emptyText' => '<div class="col"><p class="text-center">No staff members found.</p></div>',
        'options' => [
            'tag' => 'div',
            'class' => 'row',
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'col-lg-4 col-md-6 mb-5',
        ],
        'pager' => [
            'prevPageLabel' => '<i class="fa fa-angle-left"></i> Previous',
            'nextPageLabel' => 'Next <i class="fa fa-angle-right"></i>',
            'maxButtonCount' => 5,
            'options' => [
                'tag' => 'nav',
                'class' => 'pagination justify-content-center mt-4',
                'aria-label' => 'Page Navigation',
            ],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
        ],
        'itemView' => '_index_feature',
    ]); ?>
</div>
