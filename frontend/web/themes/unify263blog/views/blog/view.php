<?php

namespace frontend\web\themes\unify263blog\views\blog;

use Yii;
use yii\helpers\Html;
use kartik\social\TwitterPlugin;
use kartik\social\FacebookPlugin;
use DOMDocument;
use DOMXPath;

/**
 * @var yii\web\View $this
 * @var backend\models\Blog $model
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->content = $model->configureContentImage();
$model->content = $model->configureContentTable();

$unset = '#NA';


$model->content = str_replace('&nbsp;', '', $model->content);


$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($model->content);
$xpath = new DOMXPath($dom);

//BUANG SEMUA STYLE
//$nodes = $xpath->query("//*[@style]");
//foreach ($nodes as $node) {
//  $node->removeAttribute('style');
//}

foreach ($xpath->query("//p") as $node) {
    $node->setAttribute("class", "g-color-gray-dark-v2 text-justify");
}

foreach ($xpath->query("//blockquote") as $node) {
    $node->setAttribute("class", "blockquote g-brd-left g-brd-2 g-brd-gray-light-v4 g-brd-primary--hover text-uppercase g-font-size-22 g-transition-0_2 g-pl-20 g-mb-30");
}

foreach ($xpath->query("//img") as $node) {
    $node->setAttribute("style", "");
    $node->setAttribute("class", "img-fluid");
}

$newContent = str_replace('%09', '', $dom->saveHtml());
?>

<?php
    Yii::$app->params['meta_author']['content']             = (!empty($model->author_id)) ? $model->author->title:'-';
    Yii::$app->params['meta_description']['content']        = $model->description;
    Yii::$app->params['meta_keywords']['content']           = $model->tags;
    
//FACEBOOK
    Yii::$app->params['og_site_name']['content']    = Yii::$app->name;
    Yii::$app->params['og_title']['content']        = $model->title;
    Yii::$app->params['og_description']['content']  = $model->description;
    Yii::$app->params['og_type']['content']         = 'website';
    Yii::$app->params['og_image']['content']        = 'https://'.Yii::$app->request->serverName.$model->getCover($model->content);
    Yii::$app->params['og_url']['content']          = 'https://'. Yii::$app->request->serverName.
        Yii::$app->getUrlManager()->createUrl(['blog/view', 'id' => $model->id, 'title' => $model->title
    ]);
    Yii::$app->params['og_updated_time']['content'] = $model->updated_at;

//TWITTER
    Yii::$app->params['twitter_title']['content']        = $model->title;
    Yii::$app->params['twitter_description']['content']  = $model->description;
    Yii::$app->params['twitter_card']['content']         = 'summary_large_image';//summary_large_image
    Yii::$app->params['twitter_image']['content']        = 'https://'.Yii::$app->request->serverName.$model->getCover($model->content);
    Yii::$app->params['twitter_url']['content']          = 'https://'. Yii::$app->request->serverName.
        Yii::$app->getUrlManager()->createUrl(['blog/view', 'id' => $model->id, 'title' => $model->title
    ]);

//GOOGLE PLUS
    Yii::$app->params['googleplus_name']['content']        = $model->title;
    Yii::$app->params['googleplus_description']['content'] = $model->description;
    Yii::$app->params['googleplus_image']['content']       = 'https://'.Yii::$app->request->serverName.$model->getCover($model->content);
?>

<span itemprop="image" itemscope itemtype="image/jpeg"> 
    <link itemprop="url" href=<?='https://'.Yii::$app->request->serverName.$model->getCover($model->content);?>> 
</span>


<article class="g-mb-60">
    <header class="g-mb-30">
        <h2 class="h1 g-mb-15"><?= $model->title; ?></h2>

        <ul class="list-inline d-sm-flex g-color-gray-dark-v4 mb-0">
            <li class="list-inline-item">
                <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
            </li>
            <li class="list-inline-item g-mx-10">/</li>
            <li class="list-inline-item">
                <?= $model->category->title; ?>
            </li>
            <li class="list-inline-item g-mx-10">/</li>
            <li class="list-inline-item">
                <?= Html::a($model->author->title, $model->author->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v4 g-color-primary--hover']) ?>
            </li>

            <li class="list-inline-item ml-auto">
                <i class="icon-eye u-line-icon-pro align-middle mr-1"></i> <?= $model->view_counter ?>
            </li>
        </ul>

        <hr class="g-brd-gray-light-v4 g-my-15">

        <ul class="list-inline text-uppercase mb-0">
            <li class="list-inline-item">
                <span style="float:left">
                    <?=
                        FacebookPlugin::widget([
                            'type' => FacebookPlugin::SHARE,
                            'settings' => [
                                'size' => 'large',
                                'layout' => 'button',
                                'mobile_iframe' => 'false']]);
                    ?>
                </span>
            </li>
            <li class="list-inline-item g-mr-10">
                <?=
                    TwitterPlugin::widget([
                        'type' => TwitterPlugin::SHARE,
                        'settings' => ['size' => 'large']
                    ]);
                ?>

            </li>

        </ul>
    </header>



    <div class="g-font-size-16 g-line-height-1_8 g-mb-30 text-justify">
        <?= $newContent; ?>
    </div>


    <hr class="g-brd-gray-light-v4">
    </hr>

    <!-- Sources & Tags -->
    <div class="g-mb-30">
        <h6 class="g-color-gray-dark-v1">
            <strong class="g-mr-5">Tags:</strong>
            <?= implode(' ', $model->getTagLinksWithBadge('u-tags-v1 g-font-size-12 g-brd-around g-brd-gray-light-v4 g-bg-primary--hover g-brd-primary--hover g-color-black-opacity-0_8 g-color-white--hover rounded g-py-6 g-px-15 g-mr-5'));?>
        </h6>
    </div>
    <!-- End Sources & Tags -->

    <!-- Author Block -->
    <div class="g-mb-60">
        <div class="u-heading-v3-1 g-mb-30">
            <h2 class="h5 u-heading-v3__title g-color-gray-dark-v1 text-uppercase g-brd-primary">
                About The Author
            </h2>
        </div>

        <div class="media g-brd-around g-brd-gray-light-v4 rounded g-pa-30 g-mb-20">
            <?php
                $imageUrl = (empty($model->author_id)) ? $model->getDefaultAuthorImage() : $model->author->getImageUrl();
                $authorImage = str_replace('frontend', 'backend', $imageUrl);
                echo Html::img($authorImage, ['class' => 'd-flex u-shadow-v25 g-width-80 g-height-80 rounded-circle g-mr-15', 'style' => 'width:100px;height:100px'], ['alt' => 'alt image']);
            ?>

            <div class="media-body">
                <h4 class="g-color-gray-dark-v1 g-mb-15">
                    <?php
                        $authorUrl = (empty($model->author_id)) ? $unset : Html::a($model->author->title, $model->author->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v1 g-color-primary--hover']);
                        echo $authorUrl;
                    ?>
                </h4>

                <div class="g-mb-15">
                    <p class="g-color-gray-dark-v2">
                        <?= (empty($model->author_id)) ? $unset : $model->author->description; ?>
                    </p>
                </div>

                <!-- <ul class="list-inline mb-0">
                                <li class="list-inline-item g-mr-10">
                                    <a class="u-icon-v3 u-icon-size--xs g-font-size-12 g-bg-gray-light-v5 g-bg-primary--hover g-color-gray-dark-v5 g-color-white--hover rounded-circle"
                                        href="#">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item g-mr-10">
                                    <a class="u-icon-v3 u-icon-size--xs g-font-size-12 g-bg-gray-light-v5 g-bg-primary--hover g-color-gray-dark-v5 g-color-white--hover rounded-circle"
                                        href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item g-mr-10">
                                    <a class="u-icon-v3 u-icon-size--xs g-font-size-12 g-bg-gray-light-v5 g-bg-primary--hover g-color-gray-dark-v5 g-color-white--hover rounded-circle"
                                        href="#">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                            </ul> -->
            </div>
        </div>
    </div>
    <!-- End Author Block -->


    <div class="g-mb-60">
        <div class="u-heading-v3-1 g-mb-30">
            <h2 class="h5 u-heading-v3__title g-color-gray-dark-v1 text-uppercase g-brd-primary">Comments</h2>
        </div>

        <?php if(Yii::$app->params['GraphComment']==false){?>
            <div class="alert alert-warning">
                Comment has been disabled.
            </div>
        <?php } else { ?>
            <div id="graphcomment"></div>
            <script type="text/javascript">

              /* - - - CONFIGURATION VARIABLES - - - */

              var __semio__params = {
                graphcommentId: "<?php echo Yii::$app->params['GraphCommentId']; ?>", // make sure the id is yours

                behaviour: {
                  // HIGHLY RECOMMENDED
                    uid: "<?php echo $model->id; ?>", // uniq identifer for the comments thread on your page (ex: your page id)
                },

                // configure your variables here

              }

              /* - - - DON'T EDIT BELOW THIS LINE - - - */

              function __semio__onload() {
                __semio__gc_graphlogin(__semio__params)
              }


              (function() {
                var gc = document.createElement('script'); gc.type = 'text/javascript'; gc.async = true;
                gc.onload = __semio__onload; gc.defer = true; gc.src = 'https://integration.graphcomment.com/gc_graphlogin.js?' + Date.now();
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(gc);
              })();


            </script>
        <?php } ?>    
    </div>

</article>