<?php

use common\helper\MetaHelper;
use common\helper\MediaTypeHelper;
use common\models\OfficeMedia;
use yii\db\Expression;

use common\models\Article;
use common\models\Author;

use common\widgets\blogunify236\TagCloud;


/* @var $this yii\web\View */

$this->title = Yii::$app->name;

MetaHelper::setMetaTags();

/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION PROMO 5 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */

$promoBlogs = Article::find()->limit(5)
    ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
    ->orderBy(['date_issued'=>SORT_DESC])->all();


/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION NEWS 5 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */

//EXAMPLE : SELECT * FROM tbl_table LIMIT 5,10;  # Retrieve rows 6-15
$newsBlogs = Article::find()->limit(5)->offset(5)
    ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
    ->orderBy(['date_issued'=>SORT_DESC])->all();

/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION PINNED POST 3 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */
$pinnedBlogs = Article::find()->limit(3)
->where([
    'publish_status' => Article::PUBLISH_STATUS_YES,
    'pinned_status' => Article::PINNED_STATUS_YES
])
->orderBy(['date_issued'=>SORT_DESC])->all();

/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION LINKS 6 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */

 $siteLinks = OfficeMedia::find()->limit(6)
     ->where(['media_type'=>MediaTypeHelper::getLink()])
     ->orderBy(['id'=>SORT_ASC])->all();


/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION POPULAR BLOG
 * 2 ITEM DI TENGAH
 * 4 ITEM DI BAWAHNYA
 * /////////////////////////////////////////////////////////////////////////////
 */

$popularBlogsPrimary = Article::find()->limit(2)
        ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
        ->andWhere(['>','view_counter','100'])
        //->andWhere(['between','view_counter','10','199'])
        ->orderBy(['date_issued'=>SORT_DESC])->all();

$popularBlogSecondary = Article::find()->limit(6)
        ->where(['publish_status' => Article::PUBLISH_STATUS_YES])
        ->andWhere(['>','view_counter','200'])
        //->andWhere(['between','view_counter','200','99999'])
        ->orderBy(['date_issued'=>SORT_DESC])->all();

/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION AUTHOR : 5 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */

$authors = Author::find()->limit(5)
->where(['<>','id','1'])
->orderBy((new Expression('rand()')))->all();

/**
 * /////////////////////////////////////////////////////////////////////////////
 * SECTION OTHER POST 5 ITEM
 * /////////////////////////////////////////////////////////////////////////////
 */
$otherBlogs = Article::find()->limit(3)
->where([
    'publish_status' => Article::PUBLISH_STATUS_YES,
])
->orderBy((new Expression('rand()')))->all();

?>


<!-- Promo Block -->
<section class="g-py-50">
    <div class="container">
        <!-- News Section -->
        <div class="row no-gutters">
            <div class="col-lg-6 g-pr-1--lg g-mb-30 g-mb-2--lg">
                <!-- Article -->
                <?php
                    foreach ($promoBlogs as $i => $modelItemData) {
                        if ($i == 0) {
                            echo $this->render('_promo_blog_1', ['model' => $modelItemData]);
                        }
                } ?>
                <!-- End Article -->
            </div>

            <div class="col-lg-6 g-pl-1--lg g-mb-30 g-mb-2--lg">
                <!-- Article -->
                <?php
                    foreach ($promoBlogs as $i => $modelItemData) {
                        if ($i == 1) {
                            echo $this->render('_promo_blog_1', ['model' => $modelItemData]);
                        }
                } ?>
                <!-- End Article -->
            </div>

            <div class="col-lg-4 g-pr-1--lg g-mb-30 g-mb-0--lg">
                <!-- Article -->
                <?php
                    foreach ($promoBlogs as $i => $modelItemData) {
                        if ($i == 2) {
                            echo $this->render('_promo_blog_2', ['model' => $modelItemData]);
                        }
                } ?>
                <!-- End Article -->
            </div>
            <div class="col-lg-4 g-pr-1--lg g-mb-30 g-mb-0--lg">
                <!-- Article -->
                <?php
                    foreach ($promoBlogs as $i => $modelItemData) {
                        if ($i == 3) {
                            echo $this->render('_promo_blog_2', ['model' => $modelItemData]);
                        }
                } ?>
                <!-- End Article -->
            </div>
            <div class="col-lg-4 g-pr-1--lg g-mb-30 g-mb-0--lg">
                <!-- Article -->
                <?php
                    foreach ($promoBlogs as $i => $modelItemData) {
                        if ($i == 4) {
                            echo $this->render('_promo_blog_2', ['model' => $modelItemData]);
                        }
                } ?>
                <!-- End Article -->
            </div>

        </div>
        <!-- News Section -->
    </div>
</section>
<!-- End Promo Block -->



<!-- News Content -->
<section class="g-pb-10">
    <div class="container">
        <!-- News Section 1 -->
        <div class="row g-mb-60">
            <!-- Articles Content -->
            <div class="col-lg-9 g-mb-50 g-mb-0--lg">
                <!-- Latest News -->
                <div class="g-mb-50">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Latest News
                        </h2>
                    </div>

                    <div class="row">
                        <!-- Article (Leftside) -->
                        <div class="col-lg-7 g-mb-50 g-mb-0--lg">
                            <?php
                                foreach ($newsBlogs as $i => $modelItemData) {
                                    if ($i == 0) {
                                        echo $this->render('_news_main_left', ['model' => $modelItemData]);
                                    }
                            } ?>

                        </div>
                        <!-- End Article (Leftside) -->

                        <!-- Article (Rightside) -->
                        <div class="col-lg-5">
                            <!-- Article -->
                            <?php
                                foreach ($newsBlogs as $i => $modelItemData) {
                                    if ($i > 0) {
                                        echo $this->render('_news_main_right', ['model' => $modelItemData]);
                                    }
                            } ?>
                            <!-- End Article -->
                        </div>
                        <!-- End Article (Rightside) -->
                    </div>
                </div>
            </div>
            <!-- End Articles Content -->


            <!-- Sidebar -->
            <div class="col-lg-3">

                <!-- News Pinned -->
                <div class="g-mb-20">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Pinned News
                        </h2>
                    </div>

                    <!-- Article -->
                    <?php
                        foreach ($pinnedBlogs as $i => $modelItemData) {
                            echo $this->render('_pinned_news', ['model' => $modelItemData]);
                        }
                    ?>
                </div>
                <!-- End News Pinned -->


                <!-- Useful Links -->
                <div class="g-mb-50">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Useful Links
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
                <!-- End Useful Links -->


            </div>
        </div>
        <!-- News Section 1 -->

        <!-- News Section 3 -->
        <div class="row">
            <!-- Articles Content -->
            <div class="col-lg-9 g-mb-50 g-mb-0--lg">
                <!-- Popular News -->
                <div class="g-mb-60">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Popular News
                        </h2>
                    </div>

                    <!-- START PRIMARY -->
                    <div class="row">
                        <div class="col-lg-6 g-mb-50 g-mb-0--lg">
                            <?php
                                foreach ($popularBlogsPrimary as $i => $modelItemData) {
                                    if ($i == 0) {
                                        echo $this->render('_popular_news_primary', ['model' => $modelItemData]);
                                    }
                            } ?>

                        </div>
                        <div class="col-lg-6 g-mb-50 g-mb-0--lg">
                            <?php
                                foreach ($popularBlogsPrimary as $i => $modelItemData) {
                                    if ($i == 1) {
                                        echo $this->render('_popular_news_primary', ['model' => $modelItemData]);
                                    }
                            } ?>
                        </div>
                    </div>
                    <!-- END PRIMARY -->

                    <!-- START SECONDARY -->
                    <div class="row">
                        <?php
                            //POPULAR NEWS 0 & 1
                            foreach ($popularBlogSecondary as $i => $modelItemData) {
                                    echo $this->render('_popular_news_secondary', ['model' => $modelItemData]);

                        } ?>
                    </div>
                    <!-- END SECONDARY -->

                </div>
                <!-- End Popular News -->

            </div>
            <!-- End Articles -->

            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Popular Tags -->
                <div class="g-mb-20">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Tags
                        </h2>
                    </div>

                    <ul class="u-list-inline g-font-size-11 text-uppercase mb-0">
                        <?= TagCloud::widget([
                            'title' => 'Tags',
                            'maxTags' => 10,
                        ]) ?>
                    </ul>
                </div>
                <!-- End Popular Tags -->


                <!-- Berita Lainnya -->
                <div class="g-mb-40">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Lainnya
                        </h2>
                    </div>
                    <?php
                        //BERITA LAINNYA
                        foreach ($otherBlogs as $i => $modelItemData) {
                            echo $this->render('_blog_other_right', ['model' => $modelItemData]);
                    } ?>
                </div>
                <!-- End Top Authors -->

                <!-- Top Authors -->
<!--                <div class="g-mb-40">
                    <div class="u-heading-v3-1 g-mb-30">
                        <h2 class="h5 u-heading-v3__title g-font-primary g-font-weight-700 g-color-gray-dark-v1 text-uppercase g-brd-primary">
                            Authors
                        </h2>
                    </div>
                    <?php
                        //POPULAR NEWS 2 & 3
                        //foreach ($authors as $i => $modelItemData) {
                        //    echo $this->render('_author', ['model' => $modelItemData]);
                        //}
                    ?>
                </div>-->
                <!-- End Top Authors -->


            </div>
            <!-- End Sidebar -->
        </div>
        <!-- News Section 3 -->
    </div>
</section>