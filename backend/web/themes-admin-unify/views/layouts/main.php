<?php
/** @var \yii\web\View $this */

/** @var string $content */
use backend\assets\AdminUnifyAsset;
use common\widgets\AlertBootstrap4 as Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;

AdminUnifyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
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

        <?= $this->render('header.php');?>
        
        <main class="container-fluid px-0 g-pt-65 h-100">
            <div class="row no-gutters g-pos-rel g-overflow-x-hidden">
                
                <!-- Sidebar Nav -->
                <?= $this->render('left.php');?>
                <!-- End Sidebar Nav -->

                <div class="col g-ml-45 g-ml-0--lg g-pb-65--md">
                    <div class="g-pa-20">
                        <?=
                            Breadcrumbs::widget([
                                'links' => $this->params['breadcrumbs'] ?? [],
                            ])
                        ?>
                        <?= Alert::widget() ?>
                        <?= $content ?>
                    </div>
                    <?= $this->render('footer.php');?>
                </div>
            </div>
        </main>

    <?php $this->endBody() ?>

    <!-- JS Plugins Init. -->
    <script>
      $(document).on('ready', function () {
        // initialization of custom select
        $('.js-select').selectpicker();

        // initialization of hamburger
        $.HSCore.helpers.HSHamburgers.init('.hamburger');

        // initialization of charts
        $.HSCore.components.HSAreaChart.init('.js-area-chart');
        $.HSCore.components.HSDonutChart.init('.js-donut-chart');
        $.HSCore.components.HSBarChart.init('.js-bar-chart');

        // initialization of sidebar navigation component
        $.HSCore.components.HSSideNav.init('.js-side-nav', {
          afterOpen: function() {
            setTimeout(function() {
              $.HSCore.components.HSAreaChart.init('.js-area-chart');
              $.HSCore.components.HSDonutChart.init('.js-donut-chart');
              $.HSCore.components.HSBarChart.init('.js-bar-chart');
            }, 400);
          },
          afterClose: function() {
            setTimeout(function() {
              $.HSCore.components.HSAreaChart.init('.js-area-chart');
              $.HSCore.components.HSDonutChart.init('.js-donut-chart');
              $.HSCore.components.HSBarChart.init('.js-bar-chart');
            }, 400);
          }
        });

        // initialization of range datepicker
        $.HSCore.components.HSRangeDatepicker.init('#rangeDatepicker, #rangeDatepicker2, #rangeDatepicker3');

        // initialization of datepicker
        $.HSCore.components.HSDatepicker.init('#datepicker', {
          dayNamesMin: [
            'SU',
            'MO',
            'TU',
            'WE',
            'TH',
            'FR',
            'SA'
          ]
        });

        // initialization of HSDropdown component
        $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});

        // initialization of custom scrollbar
        $.HSCore.components.HSScrollBar.init($('.js-custom-scroll'));

        // initialization of popups
        $.HSCore.components.HSPopup.init('.js-fancybox', {
          btnTpl: {
            smallBtn: '<button data-fancybox-close class="btn g-pos-abs g-top-25 g-right-30 g-line-height-1 g-bg-transparent g-font-size-16 g-color-gray-light-v3 g-brd-none p-0" title=""><i class="hs-admin-close"></i></button>'
          }
        });
      });
    </script>
    </body>
</html>
<?php
$this->endPage();
