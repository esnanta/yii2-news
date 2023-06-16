<?php
/** @var \yii\web\View $this */

/** @var string $content */
use backend\assets\AdminModernizeAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AdminModernizeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans%3A400%2C300%2C500%2C600%2C700%7CPlayfair+Display%7CRoboto%7CRaleway%7CSpectral%7CRubik">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
             data-sidebar-position="fixed" data-header-position="fixed">

            <!-- Sidebar Start -->
            <?= $this->render('left.php'); ?>
            <!--  Sidebar End -->

            <div class="body-wrapper">
                <!--  Header Start -->
                <?= $this->render('header.php'); ?>
                <!--  Header End -->

                <div class="container-fluid">
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>

                    <?= Alert::widget() ?>
                    <?= $content ?>

                    <!--  Footer Start -->
                    <?= $this->render('footer.php'); ?>
                    <!--  Footer End -->
                </div>

            </div>

        </div>


        <?php $this->endBody() ?>

    </body>
</html>
<?php
$this->endPage();
