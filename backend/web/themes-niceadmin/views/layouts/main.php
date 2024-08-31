<?php
/** @var \yii\web\View $this */

/** @var string $content */

use backend\assets\NiceAdminAsset;
use common\widgets\AlertBootstrap5 as Alert;
use yii\bootstrap5\Html;

NiceAdminAsset::register($this);
$this->registerCss("
    .card-body {
        padding: 20px 20px 20px 20px;
    }
");

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body id="page-top">

    <?php $this->beginBody() ?>

    <div id="wrapper">

        <?= $this->render('header.php'); ?>

        <!-- Sidebar Nav -->
        <aside id="sidebar" class="sidebar">
            <?= $this->render('left.php'); ?>
        </aside>
        <!-- End Sidebar Nav -->

        <main id="main" class="main">
            <section class="section dashboard">
                <?= Alert::widget() ?>
                <?= $content ?>
            </section>
        </main>

        <footer id="footer" class="footer">
            <?= $this->render('footer.php'); ?>
        </footer>

    </div>

    <?php $this->endBody() ?>

    </body>
    </html>
<?php
$this->endPage();
