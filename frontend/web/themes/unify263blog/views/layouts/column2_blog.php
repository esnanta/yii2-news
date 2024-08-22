<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php');

use common\helper\MediaTypeHelper;
use common\models\OfficeMedia;

use common\widgets\blogunify236\RecentBlogs;
use common\widgets\blogunify236\TagCloud;
/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION LINKS 6 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */    

 $siteLinks = OfficeMedia::find()->where(['media_type'=>MediaTypeHelper::getLink()])->limit(6)
 ->orderBy(['id'=>SORT_ASC])->all();
?>

<div class="container g-pt-50 g-pb-20">
    <div class="row justify-content-between">
        <div class="col-lg-9 g-mb-80">
            <div class="g-pr-20--lg">
                <div class="masonry-grid row g-mb-70">
                    <!--<div class="masonry-grid-sizer col-sm-1"></div>-->
                    <?= $content; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3 g-brd-left--lg g-brd-gray-light-v4 g-mb-80">
            
            <div class="g-mb-50">
                <div class="u-heading-v3-1 g-mb-30">
                    <h2 class="h5 u-heading-v3__title g-color-gray-dark-v1 text-uppercase g-brd-primary">Tags</h2>
                </div>                 
                <?=
                    TagCloud::widget([
                        'title' => 'Tags',
                        'maxTags' => 8,
                    ])
                ?>                  
            </div>            
            
            <div class="g-mb-50">
                <div class="u-heading-v3-1 g-mb-30">
                    <h2 class="h5 u-heading-v3__title g-color-gray-dark-v1 text-uppercase g-brd-primary">
                        Recent Posts
                    </h2>
                </div>                 
                <?=
                    RecentBlogs::widget([
                        'title' => 'Recent Posts',
                        'maxData' => 8,
                    ])
                ?>             
              
            </div>            
            
            <div class="g-mb-50">
                <div class="u-heading-v3-1 g-mb-30">
                    <h2 class="h5 u-heading-v3__title g-color-gray-dark-v1 text-uppercase g-brd-primary">
                        Links
                    </h2>
                </div>  
                <ul class="list-unstyled">
                    <?php
                        foreach ($siteLinks as $i => $siteLinkItemData) {
                    ?>
                    <li class="g-brd-bottom g-brd-gray-light-v4 g-pb-10 g-mb-12">
                        <h4 class="h6">
                            <i class="fa fa-angle-right g-color-gray-dark-v5 g-mr-5"></i>
                            <a class="u-link-v5 g-color-gray-dark-v1 g-color-primary--hover"
                                href="<?=$siteLinkItemData->description?>" target="_blank">
                                <?=$siteLinkItemData->title?>
                            </a>
                        </h4>
                    </li>
                    <?php
                    } ?>
                </ul>                 
            </div>            
            
            
        </div>
    </div>
</div>

<?php $this->endContent(); ?>