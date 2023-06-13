<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    
                                    
//                                    if (Yii::$app->user->getIsGuest()) {
//                                        echo Yii::$app->user->identity;
//                                        echo '<li>';
//                                        echo str_replace('user/user/', '', Html::a('Login', ['admin/user/login'], ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']));
//                                        echo '</li>';
//                                    } else {
//
//                                        if (Yii::$app->user->identity->isAdmin == true) {
//                                            echo '<li>';
//                                            echo Html::a('Admin', ['/backend/web/site/index'], ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
//                                            echo '</li>';
//                                        }
//
//                                        echo '<li>';
//                                        echo Html::a('Sign Out ', ['user/security/logout'], ['data-method' => 'POST', 'class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
//                                        echo '</li>';
//                                    }
                                   
    
    
    
    if (Yii::$app->user->isGuest) {
        //$loginText = str_replace('user/user/', '', Html::a('Login', ['admin/user/login'], ['class' => '']));
        echo Html::tag('div',Html::a('Login',['admin/user/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {

        echo Html::tag('div',Html::a('Admin', (['/admin/site/index']), ['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);

        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['data-confirm' => 'Logout now?', 'class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
