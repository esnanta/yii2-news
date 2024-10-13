<?php
/* @var $this View */

/* @var $content string */

use common\helper\MediaTypeHelper;
use common\models\ArticleCategory;
use common\models\Office;
use common\models\OfficeMedia;
use common\service\CacheService;
use common\service\PageService;
use common\widgets\Alert;
use frontend\assets\Bootstrap4news;
use yii\helpers\Html;
use yii\web\View;

$this->registerMetaTag(Yii::$app->params['meta_author'], 'meta_author');
$this->registerMetaTag(Yii::$app->params['meta_description'], 'meta_description');
$this->registerMetaTag(Yii::$app->params['meta_keywords'], 'meta_keywords');

$this->registerMetaTag(Yii::$app->params['og_site_name'], 'og_site_name');
$this->registerMetaTag(Yii::$app->params['og_title'], 'og_title');
$this->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
$this->registerMetaTag(Yii::$app->params['og_type'], 'og_type');
$this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
$this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
$this->registerMetaTag(Yii::$app->params['og_width'], 'og_width');
$this->registerMetaTag(Yii::$app->params['og_height'], 'og_height');
$this->registerMetaTag(Yii::$app->params['og_updated_time'], 'og_updated_time');

$this->registerMetaTag(Yii::$app->params['twitter_title'], 'twitter_title');
$this->registerMetaTag(Yii::$app->params['twitter_description'], 'twitter_description');
$this->registerMetaTag(Yii::$app->params['twitter_card'], 'twitter_card');
$this->registerMetaTag(Yii::$app->params['twitter_url'], 'twitter_url');
$this->registerMetaTag(Yii::$app->params['twitter_image'], 'twitter_image');

$this->registerMetaTag(Yii::$app->params['googleplus_name'], 'googleplus_name');
$this->registerMetaTag(Yii::$app->params['googleplus_description'], 'googleplus_description');
$this->registerMetaTag(Yii::$app->params['googleplus_image'], 'googleplus_image');

$office = Office::findOne(1);
$officeId = CacheService::getInstance()->getOfficeId();

$siteLinks = OfficeMedia::find()->limit(8)
    ->where(['media_type' => MediaTypeHelper::getLink()])
    ->orderBy(['id' => SORT_ASC])
    ->all();

$categories = ArticleCategory::find()
    ->where(['office_id' => $officeId])
    ->orderBy(['sequence' => SORT_ASC])
    ->all();

$timeLine = ArticleCategory::find()
    ->where(['office_id' => $officeId, 'time_line' => ArticleCategory::TIME_LINE_YES])
    ->orderBy(['sequence' => SORT_ASC])
    ->one();

$officeMedias = OfficeMedia::find()
    ->where(['office_id' => $officeId, 'media_type' => MediaTypeHelper::getSocial()])
    ->all();

$logo1Image = PageService::getLogo1('200px','60px');
$logo2Image = PageService::getLogo2('500px','90px');

Bootstrap4news::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="robots" content="follow"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?=
    $this->render('header.php',[
            'office'=>$office,
            'logo1Image' => $logo1Image,
            'logo2Image' => $logo2Image,
            'categories' => $categories,
            'officeMedias' => $officeMedias
    ]);
?>

    <?= Alert::widget() ?>
    <?= $content ?>

<?=
    $this->render('footer.php',[
            'office'=>$office,
            'officeMedias' => $officeMedias
        ]);
?>

<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>

<script async src="https://cse.google.com/cse.js?cx=fa142c22a7a1bf20b"></script>
