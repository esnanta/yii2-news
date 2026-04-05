<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\StaffSearch $searchModel
 */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="cube-portfolio container margin-bottom-60">
    <div class="content-xs">
            <div id="filters-container" class="cbp-l-filters-text content-xs">
                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item"> All </div>
                    <?php
                        foreach ($employments as $i => $employmentModel) {
                    ?>
                        | <div data-filter=".<?=$employmentModel->title;?>" class="cbp-filter-item"> <?=$employmentModel->title;?> </div>
                    <?php
                        }
                    ?>
            </div><!--/end Filters Container-->
    </div>


            <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'options' => [
                         //'tag' => 'div',
                         'class' => 'cbp-l-grid-agency', //Masonry Box
                         'id' => 'grid-container',//list-wrapper
                     ],        
                    'itemOptions' => [
                        //'tag' => 'li',
                        'class' => '', //Blog Grid

                    ],      

                    'pager' => [
                        'firstPageLabel' => 'first',
                        'lastPageLabel' => 'last',
                        'prevPageLabel' => '<span class="glyphicon glyphicon-chevron-left"></span>',
                        'nextPageLabel' => '<span class="glyphicon glyphicon-chevron-right"></span>',
                        'maxButtonCount' => 3,
                        // Customzing options for pager container tag
                        'options' => [
                            //'tag' => 'div',
                            'class' => 'pager pager-v4 margin-bottom-50',
                            //'id' => 'pager-container',
                        ],

                        // Customzing CSS class for pager link
                        'linkOptions' => ['class' => 'rounded-3x'],
                        'activePageCssClass' => 'active',
                        'disabledPageCssClass' => 'disabled',

                        // Customzing CSS class for navigating link
                        'prevPageCssClass' => 'previous',
                        'nextPageCssClass' => 'next',
                        'firstPageCssClass' => 'first',
                        'lastPageCssClass' => 'last',
                    ],

                    'itemView' => '_index_cube_portofilio',
                ]);
            ?>     

                                
                                
                               
</div>