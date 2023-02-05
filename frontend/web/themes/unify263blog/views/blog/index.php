<?php
use yii\widgets\ListView;
$this->title = 'Blogs';
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'options' => [
             //'tag' => 'div',
             'class' => 'masonry-grid row g-mb-70', //Masonry Box
             'id' => '',//list-wrapper
         ],        
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'masonry-grid-item col-sm-6 g-mb-30', //Blog Grid

        ],      
        
        'pager' => [
            //'firstPageLabel' => '<i class="fa fa-angle-left g-mr-5"></i> First',
            //'lastPageLabel' => 'last',
            'prevPageLabel' => '<i class="fa fa-angle-left g-mr-5"></i> Previous',
            'nextPageLabel' => 'Next <i class="fa fa-angle-right g-mr-5"></i>',
            'maxButtonCount' => 10,

            // Customzing options for pager container tag
            'options' => [
                'tag' => 'nav',
                'class' => 'text-center container g-pr-20--lg',
                'id'=>'stickyblock-end',
                'aria-label'=>'Page Navigation'
            ],

            'linkContainerOptions'=>[
                'tag' => 'li',
                'class' => 'list-inline-item float-center g-hidden-xs-down',                
            ],
            // Customzing CSS class for pager link
            'linkOptions' => ['class' => 'u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14'],
            'activePageCssClass' => 'u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14',
            'disabledPageCssClass' => 'u-pagination-v1__item u-pagination-v1-4 g-brd-gray-light-v3 g-brd-primary--hover g-rounded-50 g-pa-7-16',

            // Customzing CSS class for navigating link
            //'firstPageCssClass' => 'u-pagination-v1__item u-pagination-v1-4 g-brd-gray-light-v3 g-brd-primary--hover g-rounded-50 g-pa-7-16',
            //'lastPageCssClass' => 'last',
            'prevPageCssClass' => 'float-left g-hidden-xs-down g-rounded-50 g-pa-7-14',
            'nextPageCssClass' => 'float-right g-hidden-xs-down g-rounded-50 g-pa-7-14',            
        ],
        
        'itemView' => '_index_grid',
    ]);
?>                         
