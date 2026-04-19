<?php
/**
 * @var View   $this
 * @var string $content
 */

use common\helpers\MetaHelper;
use common\service\LayoutService;
use frontend\assets\Bootstrap4news;
use yii\helpers\Html;
use yii\web\View;

MetaHelper::registerMetaTags($this);

$layoutData = LayoutService::getLayoutData('200px', '60px', '500px', '90px');
$office = $layoutData['office'];
$categories = $layoutData['categories'];
$officeMedias = $layoutData['officeMedias'];
$logo1Image = $layoutData['logo1Image'];
$logo2Image = $layoutData['logo2Image'];

Bootstrap4news::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">

<head>
    <meta name="robots" content="follow"/>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="<?php echo Yii::getAlias('@web'); ?>/favicon.ico">

    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>

<body>
<?php $this->beginBody(); ?>

<?php echo $this->render('header.php', [
    'office' => $office,
    'logo1Image' => $logo1Image,
    'logo2Image' => $logo2Image,
    'categories' => $categories,
    'officeMedias' => $officeMedias,
]); ?>

    <?php // AlertBootstrap4::widget()?>
    <?php echo $content; ?>

<?php echo $this->render('footer.php', [
    'office' => $office,
    'officeMedias' => $officeMedias,
]); ?>

<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage(); ?>

<script async src="https://cse.google.com/cse.js?cx=40a3035444fb94798"></script>
