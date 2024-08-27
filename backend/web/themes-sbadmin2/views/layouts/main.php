<?php
/** @var \yii\web\View $this */

/** @var string $content */

use backend\assets\SbAdmin2;
use common\widgets\AlertBootstrap5 as Alert;
use yii\bootstrap5\Html;

SbAdmin2::register($this);
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


        <!-- Sidebar Nav -->
        <?= $this->render('left.php'); ?>
        <!-- End Sidebar Nav -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?= $this->render('header.php'); ?>

                <div class="container-fluid">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>

            <!-- Footer -->
            <?= $this->render('footer.php'); ?>
            <!-- End Footer -->
        </div>
    </div>

    <?php $this->endBody() ?>

    </body>
    </html>
<?php
$this->endPage();
