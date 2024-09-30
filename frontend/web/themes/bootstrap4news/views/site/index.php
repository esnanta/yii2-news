<?php

use common\domain\AssetUseCase;
use common\helper\ContentHelper;
use common\helper\MetaHelper;
use common\service\ArticleService;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = Yii::$app->name;

MetaHelper::setMetaTags();

$articleService = new ArticleService();
$articlesSlider = $articleService->getLatestArticles(3);
$articlesPromo = $articleService->getLatestArticlesByOffset(4,4);
$articlesPopular = $articleService->getPopularArticles(4);
$articlesLatest = $articleService->getLatestArticlesByOffset(4,8);
$articlesPinned = $articleService->getPinnedArticles(4);
$articlesRandom = $articleService->getRandomArticles(9);
?>


<!-- Top News Start-->
<div class="top-news">
    <div class="container">
        <div class="row">
            <div class="col-md-6 tn-left">
                <div class="row tn-slider">
                    <?php foreach ($articlesSlider as $i => $article) { ?>

                        <div class="col-md-6">
                            <div class="tn-img">
                                <?= Html::img(ContentHelper::getCover($article->content));?>
                                <div class="tn-title">
                                    <?= Html::a($article->title, $article->getUrl()) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-6 tn-right">
                <div class="row">
                    <?php foreach ($articlesPromo as $i => $article) { ?>
                        <div class="col-md-6">
                            <div class="tn-img">
                                <?= Html::img(ContentHelper::getCover($article->content));?>
                                <div class="tn-title">
                                    <?= Html::a($article->title, $article->getUrl()) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top News End-->



<!-- Tab News Start-->
<div class="tab-news">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#popular">
                            <?= Yii::t('app', 'Popular News');?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#latest">
                            <?= Yii::t('app', 'Latest News');?>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div id="popular" class="container tab-pane active">
                        <?php foreach ($articlesPopular as $i => $article) { ?>
                            <div class="tn-news">
                                <div class="tn-img">
                                    <?= Html::img(ContentHelper::getCover($article->content));?>
                                </div>
                                <div class="tn-title">
                                    <?= Html::a($article->title, $article->getUrl()) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="latest" class="container tab-pane fade">
                        <?php foreach ($articlesLatest as $i => $article) { ?>
                            <div class="tn-news">
                                <div class="tn-img">
                                    <?= Html::img(ContentHelper::getCover($article->content));?>
                                </div>
                                <div class="tn-title">
                                    <?= Html::a($article->title, $article->getUrl()) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#m-viewed">
                            <?= Yii::t('app', 'Pinned News');?>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="m-viewed" class="container tab-pane active">
                        <?php foreach ($articlesPinned as $i => $article) { ?>
                            <div class="tn-news">
                                <div class="tn-img">
                                    <?= Html::img(ContentHelper::getCover($article->content));?>
                                </div>
                                <div class="tn-title">
                                    <?= Html::a($article->title, $article->getUrl()) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Tab News Start-->


<!-- Main News Start-->
<div class="main-news">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">

                    <?php foreach ($articlesRandom as $i => $article) { ?>
                        <div class="col-md-4">
                            <div class="mn-img">
                                <?= Html::img(ContentHelper::getCover($article->content));?>
                                <div class="mn-title">
                                    <?= Html::a($article->title, $article->getUrl()) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <div class="col-lg-3">
                <div class="mn-list">
                    <h2><?= Yii::t('app', 'Read More');?></h2>
                    <ul>
                        <?php foreach ($articlesLatest as $i => $article) { ?>
                            <li>
                                <?= Html::a($article->title, $article->getUrl()) ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main News End-->