<?php
use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\models\Product $model
 */

$this->title = 'Portfolio';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<!--=== Container Part ===-->
<div class="container">
       
    <div class="headline">
        <h2>Plan & Pricing</h2>
    </div>     
    
    <div class="row margin-bottom-40">
  
        <?php
            foreach ($providerPricing->getModels() as $i => $pricingModel) {
        ?>                    
                <div class="col-md-3 col-sm-6">
                    <div class="pricing hover-effect">
                        <div class="pricing-head">
                            <h3><?= $pricingModel->title?><span><?= $pricingModel->product->title?></span></h3>
                            <h4><i>Rp</i><i><?= Yii::$app->formatter->asDecimal($pricingModel->price)?></i> <span><?= $pricingModel->measure->title?></span></h4>
                        </div>
                        <ul class="pricing-content list-unstyled">
                            <?php
                                foreach ($pricingModel->pricingDetails as $i => $pricingDetailModel) {
                            ?>              
                                    <li>
                                        <?= $pricingDetailModel->feature->icon?> <?= $pricingDetailModel->title?>
                                        <span class="pull-right">
                                            <i class="fa fa-times" style="color:red"></i>
                                        </span>
                                    </li>
                            <?php
                                }
                            ?>                            
                        </ul>
                        <div class="pricing-footer">
                            <p><?= $pricingModel->description?></p>
                            <a class="btn-u" href="#"><i class="fa fa-shopping-cart"></i> Purchase Now</a>
                        </div>
                    </div>                
                </div>
        <?php
            }
        ?>  
        <div class="col-md-3 col-sm-6">
            <div class="tag-box tag-box-v3">
                <h2><?= $pricingModel->product->title?></h2>
                <?= $pricingModel->product->description?>
                <hr>
                <?= $pricingModel->product->content?>
            </div>
        </div>
    </div>
    
    <div class="headline">
        <h2>Showcase</h2>
    </div>
    
    <div class="cube-portfolio">
        <div id="grid-container" class="cbp-l-grid-agency">


            <?php
                foreach ($providerProductImage->getModels() as $i => $imageModel) {
            ?>         
                    <div class="cbp-item" style="width: 270px; left: 290px; top: 0px;">
                        <div class="cbp-caption margin-bottom-20">
                            <div class="cbp-caption-defaultWrap">
                                <?=Html::img($imageModel->getImageUrl(), ['style' => 'width:270px;height:175px']);?>
                            </div>
                            <div class="cbp-caption-activeWrap">
                                <div class="cbp-l-caption-alignCenter">
                                    <div class="cbp-l-caption-body">
                                        <ul class="link-captions no-bottom-space">
                                            <!--<li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>-->
                                            <li><a href="<?=$imageModel->getImageUrl();?>" class="cbp-lightbox" data-title="<?=$imageModel->title;?>"><i class="rounded-x fa fa-search"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cbp-title-dark">
                            <div class="cbp-l-grid-agency-title"><?=$imageModel->title;?></div>
                            <div class="cbp-l-grid-agency-desc"><?=$imageModel->description;?></div>
                        </div>  
                    </div>
            <?php
                }
            ?> 

        </div>
    </div>  
    
</div>
<!--=== End Container Part ===-->