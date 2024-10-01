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
$img = Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()), ['class' => 'img-fluid rounded', 'style' => 'width:250px;height:250px', 'alt' => 'alt image']);
?>

<div class="row">


    <!-- Profile Sidebar -->
    <div class="col-lg-3 mb-4">
        <!-- User Image -->
        <div class="card border">
            <figure class="figure">
                <?= Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()), ['class' => 'img-fluid w-100 rounded', 'alt' => 'alt image']); ?>
            </figure>

            <!-- Figure Caption -->
            <figcaption class="figure-caption text-center">
                <span class="badge badge-primary"><?= $model->title; ?></span>
            </figcaption>
        </div>
        <!-- End User Image -->

        <!-- Sidebar Navigation -->
        <div class="list-group mt-3">
            <?php
            $activeCategory = ($categoryTitle == "All") ? 'active' : '';
            $linkTextStyle = ($categoryTitle == "All") ? '<span class="text-white">All</span>' : 'All';
            ?>

            <!-- Overall -->
            <span class="list-group-item <?= $activeCategory; ?>">
            <span><i class="icon-home mr-2"></i>
                <?= Html::a($linkTextStyle, Yii::$app->getUrlManager()->createUrl([
                    'author/view',
                    'id' => $model->id,
                    'title' => $model->title,
                    'cat' => null
                ])); ?>
            </span>
        </span>
            <!-- End Overall -->

            <?php
            foreach ($categories as $i => $categoryModel) {
                if ($categoryModel->countAuthorBlog($model->id) > 0) {
                    $activeCategory = ($categoryTitle == $categoryModel->title) ? 'active' : '';
                    $linkTextStyle = ($categoryTitle == $categoryModel->title) ? '<span class="text-white">' . $categoryModel->title . '</span>' : $categoryModel->title;
                    $badgeColor = ($categoryTitle == $categoryModel->title) ? 'badge-primary' : 'badge-secondary';
                    ?>
                    <span class="list-group-item <?= $activeCategory; ?>">
                    <span>
                        <i class="icon-layers mr-2"></i>
                        <?= Html::a($linkTextStyle, Yii::$app->getUrlManager()->createUrl([
                            'author/view',
                            'id' => $model->id,
                            'title' => $model->title,
                            'cat' => $categoryModel->id
                        ])); ?>
                    </span>
                    <span class="badge <?= $badgeColor; ?> float-right"><?= $categoryModel->countAuthorBlog($model->id); ?></span>
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
    <div class="col-lg-9 mb-4">

        <div class="card border-0 mb-4">
            <!-- Panel Header -->
            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                <h3 class="h6 mb-0">
                    <i class="icon-briefcase mr-2"></i> Posting <?= $categoryTitle ?>
                </h3>
            </div>

            <?=
            ListView::widget([
                'dataProvider' => $blogProvider,
                'summary' => false,
                'emptyText' => '',
                'options' => [
                    'tag' => 'div',
                    'class' => 'timeline',
                ],

                'itemOptions' => [
                    'tag' => 'span',
                    'class' => 'timeline-item text-center text-md-left mb-4',
                ],

                'pager' => [
                    'prevPageLabel' => '<i class="fa fa-angle-left mr-2"></i> Previous',
                    'nextPageLabel' => 'Next <i class="fa fa-angle-right ml-2"></i>',
                    'maxButtonCount' => 10,

                    // Pager container options
                    'options' => [
                        'tag' => 'nav',
                        'class' => 'text-center',
                        'aria-label' => 'Page Navigation'
                    ],

                    'linkContainerOptions' => [
                        'tag' => 'li',
                        'class' => 'page-item',
                    ],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',

                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                ],

                'itemView' => '_view_timeline',
            ]);
            ?>
        </div>

    </div>
    <!-- End Timeline Content -->
</div>