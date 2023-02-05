<?php
use yii\helpers\Html;
use common\widgets\portfolio7\RecentBlogs;
use common\widgets\portfolio7\TagCloud;
use common\widgets\portfolio7\Breadcrumbs;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php'); 
?>
<?=
    Breadcrumbs::widget([
        'indexTitle' => Html::a('Index', ['blog/index'], ['class' => 'u-link-v5 g-color-main g-color-primary--hover']),
        'pageTitle' => 'Blog',
    ]); 
?> 


<div class="container g-pt-100 g-pb-20">
    <div class="row justify-content-between">
        <div class="col-lg-9 g-mb-80">
            <?= $content; ?>
        </div>


        <div class="col-lg-3 g-brd-left--lg g-brd-gray-light-v4 g-mb-80">
            <div class="g-pl-20--lg">
                <!-- Tags -->
                <div class="g-mb-50">
                    <h3 class="h5 g-color-black g-font-weight-600 mb-4">Tags</h3>
                    <ul class="list-unstyled g-font-size-13 mb-0">
                        <?= TagCloud::widget([
                            'title' => 'Tags',
                            'maxTags' => 5,
                        ]) ?>   
                    </ul>
                </div>
                <!-- End Tags -->

                <hr class="g-brd-gray-light-v4 g-mt-50 mb-0">

                <div id="stickyblock-start">
                    <div class="js-sticky-block g-sticky-block--lg g-pt-50" data-responsive="true" data-start-point="#stickyblock-start" data-end-point="#stickyblock-end">
                        <!-- Publications -->
                        <div class="g-mb-50">
                            <h3 class="h5 g-color-black g-font-weight-600 mb-4">Publications</h3>
                            
                            <?= RecentBlogs::widget([
                                'title' => 'Recent Blog',
                                'maxData' => 5,
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