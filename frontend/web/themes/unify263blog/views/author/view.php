<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
$img = Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()), ['class' => 'img-responsive img-bordered full-width', 'style' => 'width:250px;height:250px'], ['alt' => 'alt image']);
?>


<!-- Profile Sidebar -->
<div class="col-lg-3 g-mb-50 g-mb-0--lg">
    <!-- User Image -->
    <div class="u-block-hover g-pos-rel g-brd-around g-brd-gray-light-v4">
        <figure>
            <?=
            Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()),
                ['class' => 'img-fluid w-100 u-block-hover__main--zoom-v1'],
                ['alt' => 'alt image']);
            ?>
        </figure>

        <!-- Figure Caption -->
        <figcaption class="u-block-hover__additional--fade g-bg-black-opacity-0_5 g-pa-30">
            <div class="u-block-hover__additional--fade u-block-hover__additional--fade-up g-flex-middle">
                <!-- Figure Social Icons -->
                <!--<ul class="list-inline text-center g-flex-middle-item--bottom g-mb-20">
                    <li class="list-inline-item align-middle g-mx-7">
                        <a class="u-icon-v1 u-icon-size--md g-color-white" href="#">
                            <i class="icon-note u-line-icon-pro"></i>
                        </a>
                    </li>
                    <li class="list-inline-item align-middle g-mx-7">
                        <a class="u-icon-v1 u-icon-size--md g-color-white" href="#">
                            <i class="icon-notebook u-line-icon-pro"></i>
                        </a>
                    </li>
                    <li class="list-inline-item align-middle g-mx-7">
                        <a class="u-icon-v1 u-icon-size--md g-color-white" href="#">
                            <i class="icon-settings u-line-icon-pro"></i>
                        </a>
                    </li>
                </ul>-->
                <!-- End Figure Social Icons -->
            </div>
        </figcaption>
        <!-- End Figure Caption -->

        <!-- User Info -->
        <span class="g-pos-abs g-top-20 g-left-0">
                <span class="btn btn-sm u-btn-primary rounded-0"><?= $model->title; ?></span>
            <!--<small class="d-block g-bg-black g-color-white g-pa-5">Project Manager</small>-->
            </span>
        <!-- End User Info -->
    </div>
    <!-- User Image -->

    <!-- Sidebar Navigation -->
    <div class="list-group list-group-border-0 g-mb-40">
        <?php
        $activeCategory = ($categoryTitle == "All") ? 'active' : '';
        $linkTextStyle = ($categoryTitle == "All") ? '<span style="color:white">All</span>' : 'All';
        ?>
        <!-- Overall -->
        <span class="list-group-item justify-content-between <?= $activeCategory; ?>">
                <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i> 
                    <?= Html::a($linkTextStyle, Yii::$app->getUrlManager()->createUrl(
                        [
                            'author/view',
                            'id' => $model->id,
                            'title' => $model->title,
                            'cat' => null
                        ]
                    ))
                    ?>                    
                </span>
            </span>
        <!-- End Overall -->

        <?php
        foreach ($categories as $i => $categoryModel) {
            if ($categoryModel->countAuthorBlog($model->id) > 0) {
                $activeCategory = ($categoryTitle == $categoryModel->title) ? 'active' : '';
                $linkTextStyle = ($categoryTitle == $categoryModel->title) ? '<span style="color:white">' . $categoryModel->title . '</span>' : $categoryModel->title;
                $backgroundStyle = ($categoryTitle == $categoryModel->title) ? 'white' : 'primary';
                $countTextStyle = ($categoryTitle == $categoryModel->title) ? 'blue' : 'white';
                ?>
                <span class="list-group-item list-group-item-action justify-content-between <?= $activeCategory; ?>">
                    <span>
                        <i class="icon-layers g-pos-rel g-top-1 g-mr-8"></i> 
                        <?= Html::a($linkTextStyle, Yii::$app->getUrlManager()->createUrl([
                            'author/view',
                            'id' => $model->id,
                            'title' => $model->title,
                            'cat' => $categoryModel->id]))
                        ?>
                    </span>
                    <span class="u-label g-font-size-11 g-bg-<?= $backgroundStyle; ?> g-rounded-20 g-px-10">
                        <span style="color:<?= $countTextStyle; ?>"><?= $categoryModel->countAuthorBlog($model->id); ?></span>
                    </span>
                </span>
                <?php
            }
        }
        ?>

    </div>
    <!-- End Sidebar Navigation -->

</div>
<!-- End Profile Sidebar -->

<!-- Timeline Content -->
<div class="col-lg-9 g-mb-50 g-mb-0--lg">

    <div class="card border-0 rounded-0 g-mb-40 g-brd-around g-brd-gray-light-v4 g-pa-20">
        <!-- Panel Header -->
        <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
            <h3 class="h6 mb-0">
                <i class="icon-briefcase g-pos-rel g-top-1 g-mr-5"></i> Posting <?= $categoryTitle ?>
            </h3>

        </div>


        <?=
        ListView::widget([
            'dataProvider' => $blogProvider,
            'summary' => false,
            'emptyText' => '',
            'options' => [
                'tag' => 'div',
                'class' => 'u-timeline-v3-wrap',
                //'id' => '',
            ],

            'itemOptions' => [
                'tag' => 'span',
                'class' => 'u-timeline-v3 d-block text-center text-md-left g-parent u-link-v5 g-mb-100',
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
                    'id' => 'stickyblock-end',
                    'aria-label' => 'Page Navigation'
                ],

                'linkContainerOptions' => [
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

            'itemView' => '_view_timeline',
        ]);
        ?>


    </div>

</div>
<!-- End Timeline Content -->