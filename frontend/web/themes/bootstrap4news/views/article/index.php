<?php

use common\helper\MetaHelper;
use yii\widgets\ListView;
$this->title = 'Articles';
MetaHelper::setMetaTags();
?>

<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'options' => [
        'class' => 'row', // Bootstrap 4 grid row
    ],
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'col-sm-6 mb-4', // Bootstrap 4 columns
    ],
    'pager' => [
        'prevPageLabel' => '<i class="fa fa-angle-left mr-2"></i> Previous', // Bootstrap 4 margin utility
        'nextPageLabel' => 'Next <i class="fa fa-angle-right ml-2"></i>',
        'maxButtonCount' => 10,

        // Surrounding container with Bootstrap 4 navigation classes
        'options' => [
            'tag' => 'nav',
            'class' => 'd-flex justify-content-center', // Bootstrap 4 flex utilities
            'aria-label' => 'Page Navigation',
        ],

        // Wrapping the links in a ul with pagination class
        'linkContainerOptions' => [
            'tag' => 'ul',
            'class' => 'pagination', // Bootstrap 4 pagination class
        ],

        // Each link gets a page-item class
        'linkOptions' => ['class' => 'page-link'], // Bootstrap 4 page link class

        'activePageCssClass' => 'page-item active',
        'disabledPageCssClass' => 'page-item disabled',

        // Prev/Next container options
        'prevPageCssClass' => 'page-item',
        'nextPageCssClass' => 'page-item',
    ],
    'itemView' => '_index_grid', // Your view file for individual items
]);
?>





