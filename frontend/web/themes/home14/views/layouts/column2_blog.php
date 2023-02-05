<?php
use yii\helpers\Html;
use common\widgets\home14\RecentBlogs;
use common\widgets\home14\TagCloud;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php'); 
?>
<?=
    common\widgets\home14\Breadcrumbs::widget([
        'indexTitle' => Html::a('Index', ['blog/index'], ['class' => 'u-link-v5 g-color-white g-color-primary--hover']),
        'pageTitle' => 'Blog',
    ]); 
?> 

<div class="container g-pt-50 g-pb-20">
    <div class="row justify-content-between">
        <div class="col-lg-9 g-mb-80">
            <?= $content; ?>
        </div>


        <div class="col-lg-3 g-brd-left--lg g-brd-gray-light-v4 g-mb-80">
            
            
                
<!--             Links 
            <div class="g-mb-50">
                <h3 class="h5 g-color-black g-font-weight-600 mb-4">Links</h3>
                <ul class="list-unstyled g-font-size-13 mb-0">
                    <li><a class="d-block u-link-v5 g-color-gray-dark-v4 rounded g-px-20 g-py-8" href="#"><i class="mr-2 fa fa-angle-right"></i> People</a>
                    </li>
                    <li><a class="d-block u-link-v5 g-color-gray-dark-v4 rounded g-px-20 g-py-8" href="#"><i class="mr-2 fa fa-angle-right"></i> News Publications</a>
                    </li>
                    <li><a class="d-block u-link-v5 g-color-gray-dark-v4 rounded g-px-20 g-py-8" href="#"><i class="mr-2 fa fa-angle-right"></i> Marketing &amp; IT</a>
                    </li>
                    <li><a class="d-block u-link-v5 g-color-gray-dark-v4 rounded g-px-20 g-py-8" href="#"><i class="mr-2 fa fa-angle-right"></i> Business Strategy</a>
                    </li>
                    <li><a class="d-block active u-link-v5 g-color-black g-bg-gray-light-v5 g-font-weight-600 g-rounded-50 g-px-20 g-py-8" href="#"><i class="mr-2 fa fa-angle-right"></i> Untold Stories</a>
                    </li>
                </ul>
            </div>
             End Links             -->
            
            <div class="g-pl-20--lg">
                <div id="stickyblock-start">
                    <div class="js-sticky-block g-sticky-block--lg" data-responsive="true" data-start-point="#stickyblock-start" data-end-point="#stickyblock-end">

                        <!-- Tags -->
                        <div class="g-mb-40">
                            <h3 class="h5 g-color-black g-font-weight-600 mb-4">Tags</h3>
                            <ul class="u-list-inline mb-0">
                                <?= TagCloud::widget([
                                    'title' => 'Tags',
                                    'maxTags' => 5,
                                ]) ?>   
                            </ul>
                        </div>
                        <!-- End Tags -->

                        <hr class="g-brd-gray-light-v4 g-my-50">

                        <!-- Publications -->
                        <div class="g-mb-50">
                            <h3 class="h5 g-color-black g-font-weight-600 mb-4">Publications</h3>
                            <?= RecentBlogs::widget([
                                'title' => 'Recent Blog',
                                'maxData' => 10,
                            ]) ?>                            
                        </div>
                        <!-- End Publications -->

                        


                    </div>
                </div>

            </div>
        </div>        

    </div>
</div>





<?php $this->endContent(); ?>