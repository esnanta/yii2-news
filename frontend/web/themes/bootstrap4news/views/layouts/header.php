<?php
/**
 * @var Office              $office
 * @var OfficeSocialAccount $officeMedias
 * @var string              $logo1Image
 * @var string              $logo2Image
 */

use common\models\Office;
use common\models\OfficeSocialAccount;
use rmrevin\yii\fontawesome\FAS;
use yii\bootstrap4\Nav;
use yii\helpers\Html;

$backendBaseUrl = rtrim(Yii::getAlias('@backendUrl'), '/');
$backendLoginUrl = $backendBaseUrl.'/sign-in/login';
$backendDashboardUrl = $backendBaseUrl.'/site/index';
$currentRoute = '/'.ltrim(Yii::$app->controller->getRoute(), '/');
// Normalize route when web server internally rewrites to project web roots.
$currentRoute = preg_replace('#^/yii2-news/frontend/web/#', '/', $currentRoute);
$currentRoute = preg_replace('#^/frontend/web/#', '/', $currentRoute);
$currentSlug = Yii::$app->request->get('slug');
$currentCategoryId = Yii::$app->request->get('cat');
$menuLinkClass = 'g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20';

$menuItems = [
    [
        'label' => Yii::t('app', 'Home'),
        'url' => ['/site/index'],
        'active' => '/site/index' === $currentRoute,
    ],
    [
        'label' => Yii::t('app', 'Article'),
        'url' => ['/article/index'],
        'active' => '/article/index' === $currentRoute && empty($currentCategoryId),
    ],
    [
        'label' => Yii::t('app', 'Document'),
        'url' => ['/document/index'],
        'active' => '/document/index' === $currentRoute,
    ],
    [
        'label' => Yii::t('app', 'Staff'),
        'url' => ['/staff/index'],
        'active' => '/staff/index' === $currentRoute,
    ],
    [
        'label' => Yii::t('app', 'About'),
        'url' => ['/page/view', 'slug' => 'about'],
        'active' => '/page/view' === $currentRoute && 'about' === $currentSlug,
    ],
];

if (!empty($categories)) {
    $categoryItems = array_map(static function ($categoryModel) use ($currentRoute, $currentCategoryId) {
        $categoryId = (string) $categoryModel->id;
        $requestedCategoryId = null === $currentCategoryId ? null : (string) $currentCategoryId;

        return [
            'label' => $categoryModel->title,
            'url' => ['/article/index', 'cat' => $categoryModel->id, 'title' => $categoryModel->title],
            'active' => '/article/index' === $currentRoute && $requestedCategoryId === $categoryId,
        ];
    }, $categories);

    $menuItems[] = [
        'label' => Yii::t('app', 'Category'),
        'items' => $categoryItems,
        'active' => in_array(true, array_column($categoryItems, 'active'), true),
    ];
}

?>

<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    <p><i class="fas fa-envelope"></i><?php echo $office->email; ?></p>
                    <p><i class="fas fa-phone-alt"></i><?php echo $office->phone_number; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu">
                <?php
                if (Yii::$app->user->getIsGuest()) {
                    echo '<li>';
                    echo Html::a(FAS::icon('user'), $backendLoginUrl, ['class' => 'd-block '.$menuLinkClass]);
                    echo '</li>';
                } else {
                    $signOut = Html::a(
                        FAS::icon('sign-out-alt').' Sign Out',
                        ['/user/sign-in/logout'],
                        [
                            'data-method' => 'POST',
                            'data-confirm' => Yii::t('app', 'Are you sure you want to sign out?'),
                            'class' => $menuLinkClass,
                        ]
                    );
                    if (true == Yii::$app->user->identity->isAdmin()) {
                        echo '<li>';
                        $admin = Html::a(
                            FAS::icon('user').' Admin',
                            $backendDashboardUrl,
                            ['class' => $menuLinkClass]
                        );
                        echo $admin.' | '.$signOut;
                        echo '</li>';
                    } else {
                        echo '<li>';
                        echo $signOut;
                        echo '</li>';
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar Start -->

<!-- Brand Start -->
<div class="brand">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4">
                <div class="b-logo">
                    <?php echo Html::a($logo1Image, ['/site/index']); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="b-ads">
                    <?php echo Html::a($logo2Image, ['/site/index']); ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="b-search">
                    <form onsubmit="return executeQuery();">
                        <input id="gsc-i-id1" type="text" placeholder="Search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div id="gsc-search-box-id" style="display:none">
                    <div class="gcse-search"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand End -->

<!-- Nav Bar Start -->
<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="mr-auto">
                    <?php echo Nav::widget([
                        'options' => [
                            'class' => [
                                'navbar-nav', 'mr-auto',
                            ],
                        ],
                        'items' => $menuItems,
                    ]); ?>

                </div>
                <div class="social ml-auto">
                    <?php foreach ($officeMedias as $officeMediaItem) {  ?>
                        <a href="<?php echo $officeMediaItem->description; ?>">
                            <i class="<?php echo $officeMediaItem->title; ?>"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Nav Bar End -->

<script>
    function executeQuery() {
        var input = document.getElementById('gsc-i-id1');
        var element = google.search.cse.element.getElement('gsc-search-box-id');
        if (input.value === '') {
            return false;
        }
        element.execute(input.value);
        return false;
    }
</script>
