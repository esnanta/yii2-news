<?php

$this->beginContent('@app/views/layouts/main.php');

use common\helper\MediaTypeHelper;
use common\models\OfficeMedia;

use common\widgets\bootstrap4news\RecentBlogs;
use common\widgets\bootstrap4news\TagCloud;


$siteLinks = OfficeMedia::find()->where(['media_type' => MediaTypeHelper::getLink()])->limit(6)
    ->orderBy(['id' => SORT_ASC])->all();
?>


    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sn-container">
                        <div class="sn-content">
                            <?= $content; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">

                        <div class="sidebar-widget">
                            <h2 class="sw-title">Tags Cloud</h2>
                            <div class="tags">
                                <?=
                                TagCloud::widget([
                                    'title' => 'Tags',
                                    'maxTags' => 8,
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="sidebar-widget">

                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                <?=
                                RecentBlogs::widget([
                                    'title' => 'Recent Posts',
                                    'maxData' => 8,
                                ])
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->


<?php $this->endContent(); ?>