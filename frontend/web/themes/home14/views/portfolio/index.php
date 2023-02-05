<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\P     roductSearch $searchModel
 */

$this->title = 'Products';
//$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Cube Portfolio Blocks -->
<div class="container g-pt-50">
    <div class="row justify-content-center text-center g-mb-80">
        <div class="col-lg-8">
            <h2 class="h1 g-color-black g-font-weight-600 mb-0">We are a
                <span class="d-inline-block g-brd-bottom g-brd-2 g-brd-primary g-color-primary">creative</span> studio focusing on culture, luxury,
                <span class="d-inline-block g-brd-bottom g-brd-2 g-brd-primary g-color-primary">editorial</span> &amp; art.
            </h2>
        </div>
    </div>

    <!-- Cube Portfolio Blocks - Filter -->
    <ul id="filterControls" class="d-block list-inline text-center g-mb-50">
        <li class="list-inline-item cbp-filter-item g-color-black g-color-primary--active g-font-weight-600 g-font-size-13 text-uppercase pr-2 mb-2" role="button" 
            data-filter="*">Show All
        </li>
        
        <?php
            foreach ($productTypes as $productTypeModel) {
        ?>
                <li class="list-inline-item cbp-filter-item g-color-black g-color-primary--hover g-color-gray-dark-v5--active g-font-weight-600 g-font-size-13 text-uppercase px-2 mb-2" role="button" 
                    data-filter=".<?=$productTypeModel->title ?>"><?=$productTypeModel->title;?>
                </li>            
        <?php
            }
        ?>               
    </ul>
    <!-- End Cube Portfolio Blocks - Filter -->
</div>
<!-- End Cube Portfolio Blocks -->

<!-- Cube Portfolio Blocks - Content -->
<div class="container">
    <div class="cbp" data-controls="#filterControls" data-animation="quicksand" data-x-gap="5" data-y-gap="5" data-media-queries='[
         {"width": 1500, "cols": 4},
         {"width": 1100, "cols": 4},
         {"width": 800, "cols": 3},
         {"width": 480, "cols": 2},
         {"width": 300, "cols": 1}
         ]'>
        
        <?php 
            foreach ($products as $productModel) {
        ?>          
        
                <!-- Cube Portfolio Blocks - Item -->
                <div class="cbp-item <?=$productModel->productType->title?>">
                    <div class="u-block-hover g-parent">
                        <?=Html::img($productModel->cover, ['class' => 'img-fluid g-transform-scale-1_1--parent-hover g-transition-0_5 g-transition--ease-in-out', 'style' => 'width:300px;height:200px']);?>
                        <div class="d-flex w-100 h-100 g-bg-primary-opacity-0_6 opacity-0 g-opacity-1--parent-hover g-pos-abs g-top-0 g-left-0 g-transition-0_3 g-transition--ease-in u-block-hover__additional--fade u-block-hover__additional--fade-in g-pa-20">
                            <ul class="align-items-end flex-column list-inline mt-auto ml-auto mb-0">
                                <li class="list-inline-item">
                                    <?= 
                                            Html::a('<i class="icon-communication-095 u-line-icon-pro"></i>', 
                                                Yii::$app->getUrlManager()->createUrl(['portfolio/view', 'id'=>$productModel->id,'title'=>$productModel->title]),
                                                ['class'=>'u-icon-v2 u-icon-size--sm g-brd-white g-color-black g-bg-white rounded-circle']);
                                    ?>
                                </li>
                                <li class="list-inline-item">
                                    <a class="cbp-lightbox u-icon-v2 u-icon-size--sm g-brd-white g-color-black g-bg-white rounded-circle" href="<?=$productModel->cover;?>">
                                        <i class="icon-communication-017 u-line-icon-pro"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-center g-pa-25 mb-1">
                        <h3 class="h5 g-font-weight-600 mb-1"><?=$productModel->title?></h3>
                        <p class="mb-0"><?=$productModel->description?></p>
                    </div>
                </div>
                <!-- End Cube Portfolio Blocks - Item -->        
        
        <?php
            }
        ?>        
        
    </div>
</div>
<!-- End Cube Portfolio Blocks - Content -->

<br>
<br>


        
        
        
        
        
        
        