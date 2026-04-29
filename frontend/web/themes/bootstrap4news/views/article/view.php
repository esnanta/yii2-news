<?php

namespace frontend\web\themes\unify263blog\views\blog;

use common\helpers\ContentHelper;
use common\helpers\MetaHelper;
use common\models\Article;
use common\service\LayoutService;
use DOMDocument;
use DOMXPath;
use kartik\social\FacebookPlugin;
use kartik\social\TwitterPlugin;
use rmrevin\yii\fontawesome\FAS;
use Yii;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var Article $model
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$unset = '#NA';

$defaultCoverUrl = Yii::getAlias('@web/themes/bootstrap4news/assets/img/news-350x223-1.jpg');
$articleCover = ContentHelper::resolveCoverUrl(
    $model->thumbnail_base_url ?? null,
    $model->thumbnail_path ?? null,
    $model->body ?? $model->body ?? null,
    $defaultCoverUrl
) ?? $defaultCoverUrl;
$model->body = str_replace('&nbsp;', '', $model->body);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($model->body);
$xpath = new DOMXPath($dom);

// BUANG SEMUA STYLE
$nodes = $xpath->query('//*[@style]');
foreach ($nodes as $node) {
    $node->removeAttribute('style');
}

foreach ($xpath->query('//p') as $node) {
    $node->setAttribute('class', '');
}

foreach ($xpath->query('//blockquote') as $node) {
    $node->setAttribute('class', 'blockquote');
}

foreach ($xpath->query('//img') as $node) {
    $node->setAttribute('style', '');
    $node->setAttribute('class', 'img-fluid');
}

$newContent = str_replace('%09', '', $dom->saveHtml());

$articleUrl = $model->getUrl();
if (0 !== strpos($articleUrl, 'http://') && 0 !== strpos($articleUrl, 'https://')) {
    if ('/' !== substr($articleUrl, 0, 1)) {
        $articleUrl = '/'.$articleUrl;
    }
    $articleUrl = Yii::$app->request->hostInfo.$articleUrl;
}

$metaImageUrl = (string) $articleCover;
if ('' !== $metaImageUrl
    && !str_starts_with($metaImageUrl, 'http://')
    && !str_starts_with($metaImageUrl, 'https://')
    && !str_starts_with($metaImageUrl, '//')
    && !str_starts_with($metaImageUrl, 'data:')
) {
    if (!str_starts_with($metaImageUrl, '/')) {
        $metaImageUrl = '/'.$metaImageUrl;
    }
    $metaImageUrl = Yii::$app->request->hostInfo.$metaImageUrl;
}

$articleDescription = trim((string) ($model->description ?? ''));
if ('' === $articleDescription) {
    $articleDescription = ContentHelper::excerpt((string) $model->body, 160);
}
if ('' === $articleDescription) {
    $articleDescription = trim(LayoutService::getDescription());
}

$updatedAtRaw = $model->updated_at ?? null;
$updatedAtTimestamp = is_numeric($updatedAtRaw)
    ? (int) $updatedAtRaw
    : strtotime((string) $updatedAtRaw);
$updatedAtIso = false !== $updatedAtTimestamp ? date('c', $updatedAtTimestamp) : date('c');

MetaHelper::setMetaTags([
    'meta_author' => ['name' => 'author', 'content' => !empty($model->author_id) ? $model->author->title : '-'],
    'meta_description' => ['name' => 'description', 'content' => $articleDescription],
    'meta_keywords' => ['name' => 'keywords', 'content' => (string) $model->getTagKeywordString()],
    'og_site_name' => ['property' => 'og:site_name', 'content' => Yii::$app->name],
    'og_title' => ['property' => 'og:title', 'content' => (string) $model->title],
    'og_description' => ['property' => 'og:description', 'content' => $articleDescription],
    'og_type' => ['property' => 'og:type', 'content' => 'article'],
    'og_image' => ['property' => 'og:image', 'content' => $metaImageUrl],
    'og_url' => ['property' => 'og:url', 'content' => $articleUrl],
    'og_updated_time' => ['property' => 'og:updated_time', 'content' => $updatedAtIso],
    'twitter_title' => ['name' => 'twitter:title', 'content' => (string) $model->title],
    'twitter_description' => ['name' => 'twitter:description', 'content' => $articleDescription],
    'twitter_card' => ['name' => 'twitter:card', 'content' => 'summary_large_image'],
    'twitter_image' => ['name' => 'twitter:image', 'content' => $metaImageUrl],
    'twitter_url' => ['name' => 'twitter:url', 'content' => $articleUrl],
    'googleplus_name' => ['itemprop' => 'name', 'content' => (string) $model->title],
    'googleplus_description' => ['itemprop' => 'description', 'content' => $articleDescription],
    'googleplus_image' => ['itemprop' => 'image', 'content' => $metaImageUrl],
]);
?>

<div class="sn-container">
    <div class="sn-img">
        <?php echo Html::img($articleCover, ['class' => 'img-fluid w-100 mb-3']); ?>
    </div>
    <div class="sn-content">
        <h1 class="sn-title"><?php echo $model->title; ?></h1>
        <ul class="list-inline text-muted">
            <li class="list-inline-item">
                <?php echo Yii::$app->formatter->format($model->created_at, 'date'); ?>
            </li>
            <li class="list-inline-item mx-2">/</li>
            <li class="list-inline-item">
                <?php echo $model->category->title; ?>
            </li>
            <li class="list-inline-item mx-2">/</li>
            <li class="list-inline-item">
                <?php echo Html::a(
                    $model->author->title,
                    $model->author->getUrl(),
                    ['class' => 'text-dark font-weight-bold']
                );
?>
            </li>

            <li class="list-inline-item float-right">
                <i class="fas fa-eye mr-1"></i> <?php echo $model->view_count; ?>
            </li>
        </ul>

        <ul class="list-inline text-uppercase mb-0">
            <li class="list-inline-item">
                <span class="float-left">
                    <?php echo FacebookPlugin::widget([
                        'type' => FacebookPlugin::SHARE,
                        'settings' => [
                            'size' => 'large',
                            'layout' => 'button',
                            'mobile_iframe' => 'false',
                        ],
                    ]); ?>
                </span>
            </li>
            <li class="list-inline-item mr-2">
                <?php echo TwitterPlugin::widget([
                    'type' => TwitterPlugin::SHARE,
                    'settings' => ['size' => 'large'],
                ]); ?>
            </li>
        </ul>

        <hr class="my-3">

        <?php echo $newContent; ?>

        <hr class="my-3">

        <div class="mb-4">
            <strong class="mr-2"> <?php echo FAS::icon('user').' by: '; ?> </strong>
            <?php
            echo empty($model->author_id) ? $unset
                    : Html::a(
                        $model->author->title,
                        $model->author->getUrl(),
                        ['class' => 'text-dark font-weight-bold']
                    );
            ?>

            <h6 class="text-muted float-right float-end">
                <strong class="mr-2">Tags:</strong>
                <?php
                $styleClass = 'badge badge-primary mr-2';
                $tagLinks = [];
                foreach ($model->tags as $tagModel) {
                    $tagLinks[] = Html::a(
                        Html::encode($tagModel->title),
                        ['article/index', 'tag' => !empty($tagModel->slug) ? $tagModel->slug : $tagModel->title],
                        ['class' => $styleClass]
                    );
                }

                echo implode(' ', $tagLinks);
                ?>
            </h6>
        </div>

        <hr class="my-3">

        <?php
        $comment = false;
        if ($comment == false) {?>
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