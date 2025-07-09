<?php

namespace frontend\web\themes\unify263blog\views\blog;

use common\helper\ContentHelper;
use common\helper\IconHelper;
use common\models\Tag;
use Yii;
use yii\helpers\Html;
use kartik\social\TwitterPlugin;
use kartik\social\FacebookPlugin;
use DOMDocument;
use DOMXPath;

/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$unset = '#NA';
$model->content = ContentHelper::configureContentImage($model->content);
$model->content = ContentHelper::configureContentTable($model->content);
$articleCover   = ContentHelper::getCover($model->content,$model->cover);
$model->content = str_replace('&nbsp;', '', $model->content);


$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($model->content);
$xpath = new DOMXPath($dom);

//BUANG SEMUA STYLE
$nodes = $xpath->query("//*[@style]");
foreach ($nodes as $node) {
  $node->removeAttribute('style');
}

foreach ($xpath->query("//p") as $node) {
    $node->setAttribute("class", "");
}

foreach ($xpath->query("//blockquote") as $node) {
    $node->setAttribute("class", "blockquote");
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
    Yii::$app->params['og_image']['content']        = $articleCover;
    Yii::$app->params['og_url']['content']          = 'https://'. Yii::$app->request->serverName.$model->getUrl();
    Yii::$app->params['og_updated_time']['content'] = $model->updated_at;

//TWITTER
    Yii::$app->params['twitter_title']['content']        = $model->title;
    Yii::$app->params['twitter_description']['content']  = $model->description;
    Yii::$app->params['twitter_card']['content']         = 'summary_large_image';//summary_large_image
    Yii::$app->params['twitter_image']['content']        = $articleCover;
    Yii::$app->params['twitter_url']['content']          = 'https://'. Yii::$app->request->serverName.$model->getUrl();

//GOOGLE PLUS
    Yii::$app->params['googleplus_name']['content']        = $model->title;
    Yii::$app->params['googleplus_description']['content'] = $model->description;
    Yii::$app->params['googleplus_image']['content']       = $articleCover;
?>

<div class="sn-container">
    <div class="sn-img">
        <?= Html::img($articleCover, ['class' => 'img-fluid w-100 mb-3']); ?>
    </div>
    <div class="sn-content">
        <h1 class="sn-title"><?= $model->title; ?></h1>
        <ul class="list-inline text-muted">
            <li class="list-inline-item">
                <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
            </li>
            <li class="list-inline-item mx-2">/</li>
            <li class="list-inline-item">
                <?= $model->articleCategory->title; ?>
            </li>
            <li class="list-inline-item mx-2">/</li>
            <li class="list-inline-item">
                <?= Html::a($model->author->title, $model->author->getUrl(), ['class' => 'text-dark font-weight-bold']) ?>
            </li>

            <li class="list-inline-item float-right">
                <i class="fas fa-eye mr-1"></i> <?= $model->view_counter ?>
            </li>
        </ul>

        <ul class="list-inline text-uppercase mb-0">
            <li class="list-inline-item">
                <span class="float-left">
                    <?= FacebookPlugin::widget([
                        'type' => FacebookPlugin::SHARE,
                        'settings' => [
                            'size' => 'large',
                            'layout' => 'button',
                            'mobile_iframe' => 'false',
                        ]
                    ]); ?>
                </span>
            </li>
            <li class="list-inline-item mr-2">
                <?= TwitterPlugin::widget([
                    'type' => TwitterPlugin::SHARE,
                    'settings' => ['size' => 'large']
                ]); ?>
            </li>
        </ul>

        <hr class="my-3">

        <?= $newContent; ?>

        <hr class="my-3">

        <div class="mb-4">
            <strong class="mr-2"> <?= IconHelper::getUser(). ' by: ' ?> </strong>
            <?= empty($model->author_id) ? $unset : Html::a($model->author->title, $model->author->getUrl(), ['class' => 'text-dark font-weight-bold']); ?>

            <h6 class="text-muted float-right float-end">
                <strong class="mr-2">Tags:</strong>
                <?php
                $styleClass = 'badge badge-primary mr-2';
                $tags = $model->tags;

                echo implode(' ', Tag::getTagLinks($tags, $styleClass));
                ?>
            </h6>
        </div>

        <hr class="my-3">

        <?php if(Yii::$app->params['GraphComment']==false){?>
            <div class="alert alert-warning">
                Comment has been disabled.
            </div>
        <?php } else { ?>

            <div class="mb-4">
                <div id="graphcomment"></div>
                <script type="text/javascript">

                    /* - - - CONFIGURATION VARIABLES - - - */

                    var __semio__params = {
                        // make sure the id is yours
                        graphcommentId: "<?php echo Yii::$app->params['GraphCommentId']; ?>",

                        behaviour: {
                            // HIGHLY RECOMMENDED
                            // uniq identifer for the comments thread on your page (ex: your page id)
                            uid: "<?php echo $model->id; ?>",
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
            </div>
        <?php } ?>
    </div>
</div>