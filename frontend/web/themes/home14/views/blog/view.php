<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\models\Blog $model
 */

$this->title = $model->title;

?>

<section class="container">
    <div class="row g-mb-50">
        <div class="col-md-12 g-mb-30">
            <div class="mb-5">
                <h2 class="g-color-black mb-1"><?= $model->title; ?></h2>

                <ul class="list-inline g-font-weight-300">
                    <li class="list-inline-item g-mr-20">
                        <i class="icon-user g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> <?= $model->author->title; ?>
                    </li>                      
                    <li class="list-inline-item g-mr-20">
                        <i class="icon-info g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> <?= $model->category->title; ?>
                    </li>                      
                    <li class="list-inline-item g-mr-20">
                        <i class="icon-calendar g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?>
                    </li>
                    <li class="list-inline-item g-mr-20">
                        <i class="icon-eye g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> <?= $model->view_counter; ?>
                    </li>
                </ul>                

                <hr class="g-brd-gray-light-v4 g-my-20">

                <?= $model->content; ?>

                <br>
                
                <ul class="u-list-inline">
                    <li class="list-inline-item g-mb-10">
                        <a class="u-tags-v1 g-color-white g-bg-black g-bg-black--hover g-py-4 g-px-10" href="#!">Tags</a>
                    </li>
                    
                    <?php
                        $tagsVal        = explode(',',$model->tags);//split as array
                        foreach($tagsVal as $key => $val) {
                    ?>
                            <li class="list-inline-item g-mb-10">
                                <?= Html::a($val, Yii::$app->getUrlManager()->createUrl(['blog/index', 'tag'=>$val]),['class'=>'u-tags-v1 g-color-main g-bg-gray-light-v4 g-bg-black--hover g-color-white--hover g-py-4 g-px-10']);?>
                            </li>
                    <?php
                        }
                    ?>
                            
                </ul>                 
                
                <br>
                
                <!-- Team Block -->
                <div class="row">
                    <div class="col-lg-12 g-mb-30">
                        
                        <!-- Figure -->
                        <figure class="g-brd-around g-brd-gray-light-v4 g-rounded-4 g-pa-15">
                            <div class="d-flex justify-content-start">
                                <!-- Figure Image -->
                                <?php
                                    $imageUrl       = (empty($model->author_id)) ? $model->getDefaultAuthorImage(): $model->author->getImageUrl();
                                    $authorImage    = str_replace('frontend', 'backend', $imageUrl);            
                                ?>                                  
                                <?= Html::img($authorImage, ['class' => 'img-fluid img-thumbnail rounded-circle g-width-100 g-height-100 g-mr-15'], ['alt' => 'alt image']); ?>
                                <!-- Figure Image -->

                                <!-- Figure Info -->
                                <div class="d-block">
                                    <div class="g-mb-10">
                                        <h4 class="h5 g-mb-0"><?= (empty($model->author_id)) ? $unset: Html::a($model->author->title, $model->author->getUrl(), ['class' => '']); ?></h4>
                                        <em class="d-block g-color-primary g-font-style-normal g-font-size-default">
                                            <i class="icon-location-pin g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> 
                                            <?= $model->author->address; ?>
                                        </em>
                                    </div>
                                    <em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-12">
                                        <i class="icon-phone g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i>
                                        <?= $model->author->phone_number; ?>
                                    </em>                                    
                                    <em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13 g-mb-2">
                                        <i class="icon-envelope g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i>
                                        <?= $model->author->email; ?>
                                    </em>
                                </div>
                                <!-- End Figure Info -->
                            </div>
                        </figure>
                        <!-- End Figure -->
                    </div>


                </div>
                <!-- End Team Block -->                
                
            </div>
        </div>
    </div>
</section>