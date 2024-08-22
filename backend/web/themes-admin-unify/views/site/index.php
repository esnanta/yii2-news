<?php
/** @var yii\web\View $this */
$this->title = Yii::$app->name;

use yii\helpers\Html;
?>


<div class="row">
    <div class="col-md-4 col-xs-6">

        <!-- Panel -->
        <div class="card g-brd-gray-light-v7 g-rounded-3 g-mb-30">
            <div class="card-block g-pa-15 g-pa-30--sm">

                <!-- User Information -->
                <section class="text-center g-mb-30 g-mb-50--md">
                    <div class="d-inline-block g-pos-rel g-mb-20">

                        <?= Html::a('<i class="hs-admin-pencil g-absolute-centered g-font-size-16 g-color-white"></i>', ['/staff/update', 'id' => $staff->id], ['class' => 'u-badge-v2--lg u-badge--bottom-right g-width-32 g-height-32 g-bg-secondary g-bg-primary--hover g-transition-0_3 g-mb-20 g-mr-20']); ?>

                        <img class="img-fluid rounded-circle" src="<?= $staff->getAssetUrl() ?>" alt="<?= $staff->title; ?>">
                    </div>

                    <h3 class="g-font-weight-300 g-font-size-20 g-color-black mb-0"><?= Html::a($staff->title, ['/staff/view', 'id' => $staff->id,]); ?></h3>
                </section>
                <!-- User Information -->

                <!-- Profile Sidebar -->
                <section>
                    <ul class="list-unstyled mb-0">
                        <li class="g-brd-top g-brd-gray-light-v7 mb-0">
                            <span class="d-flex align-items-center u-link-v5 g-parent g-py-15" href="">
                                <span class="g-font-size-18 g-color-gray-light-v6 g-color-primary--parent-hover g-color-primary--parent g-mr-15">
                                    <i class="fa fa-id-badge"></i>
                                </span>

                                <span class="u-tags-v1 g-color-main g-brd-around g-brd-gray-light-v3 g-bg-gray-dark-v2--hover g-brd-gray-dark-v2--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15">
                                    <?= (!empty($authItemName)) ? $authItemName : '-'; ?>
                                </span>
                            </span>
                        </li>
                        <li class="g-brd-top g-brd-gray-light-v7 mb-0">

                            <span class="d-flex align-items-center u-link-v5 g-parent g-py-15" href="">
                                <span class="g-font-size-18 g-color-gray-light-v6 g-color-primary--parent-hover g-color-primary--parent g-mr-15">
                                    <i class="fa fa-university"></i>
                                </span>
                                <span class="g-color-gray-dark-v6 g-color-primary--parent-hover g-color-primary--parent">
                                    <?= (!empty($office->title)) ? $office->title : '-' ?>
                                </span>
                            </span>
                        </li>

                        <li class="g-brd-top g-brd-gray-light-v7 mb-0">
                            <span class="d-flex align-items-center u-link-v5 g-parent g-py-15" href="">
                                <span class="g-font-size-18 g-color-gray-light-v6 g-color-primary--parent-hover g-color-primary--parent g-mr-15">
                                    <i class="fa fa-phone"></i>
                                </span>
                                <span class="g-color-gray-dark-v6 g-color-primary--parent-hover g-color-primary--parent-active">
                                    <?= (!empty($office->phone_number)) ? $office->phone_number : '-'; ?>
                                </span>
                            </span>
                        </li>
                        <li class="g-brd-top g-brd-gray-light-v7 mb-0">
                            <span class="d-flex align-items-center u-link-v5 g-parent g-py-15" href="">
                                <span class="g-font-size-18 g-color-gray-light-v6 g-color-primary--parent-hover g-color-primary--parent g-mr-15">
                                    <i class="fa fa-send"></i>
                                </span>
                                <span class="g-color-gray-dark-v6 g-color-primary--parent-hover g-color-primary--parent-active">
                                    <?= (!empty($office->email)) ? $office->email : '-'; ?>
                                </span>
                            </span>
                        </li>
                    </ul>
                </section>

            </div>
        </div>
        <!-- End Panel -->
    </div>

    <div class="col-md-8 col-xs-6">
        <div class="row">
            <?php
//            foreach ($itemList as $i => $model) {
//                $background = "g-bg-lightblue-v3";
//
//                if ($i == 0) {
//                    $background = "g-bg-darkblue-v2";
//                }
//                if ($i == 1) {
//                    $background = "g-bg-lightred-v2";
//                }
//                if ($i == 2) {
//                    $background = "g-bg-teal-v2";
//                }
                ?>
                <div class="col-md-6 col-xs-6">
                    <!-- Panel -->
                    <div class="card g-brd-gray-light-v7 g-rounded-3 g-mb-30">
                        <div class="card h-100 g-brd-gray-light-v7 g-rounded-3">
                            <div class="card-block g-font-weight-300 g-pa-20">
                                <div class="media">
                                    <div class="d-flex g-mr-15">
                                        <div class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 <?php // $background; ?> g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                            <i class="fas fa-gas-pump g-absolute-centered"></i>
                                        </div>
                                    </div>

                                    <div class="media-body align-self-center">
                                        <div class="d-flex align-items-center g-mb-5">
                                            <span class="g-font-size-24 g-line-height-1 g-color-black">
                                                Rp. <?php //number_format($model->sell_price); ?>
                                            </span>
    <!--                                            <span class="d-flex align-self-center g-font-size-0 g-ml-5 g-ml-10--md">
                                                <i class="g-fill-gray-dark-v9">
                                                    <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g transform="translate(-21.000000, -751.000000)">
                                                    <g transform="translate(0.000000, 64.000000)">
                                                    <g transform="translate(20.000000, 619.000000)">
                                                    <g transform="translate(1.000000, 68.000000)">
                                                    <polygon points="6 20 0 13.9709049 0.576828937 13.3911999 5.59205874 18.430615 5.59205874 0 6.40794126 0 6.40794126 18.430615 11.4223552 13.3911999 12 13.9709049"></polygon>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </svg>
                                                </i>
                                                <i class="g-fill-lightblue-v3">
                                                    <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g transform="translate(-33.000000, -751.000000)">
                                                    <g transform="translate(0.000000, 64.000000)">
                                                    <g transform="translate(20.000000, 619.000000)">
                                                    <g transform="translate(1.000000, 68.000000)">
                                                    <polygon
                                                        transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)"
                                                        points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </svg>
                                                </i>
                                            </span>-->
                                        </div>

                                        <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">
                                            <?php // $model->title; ?> / <?php // date('F', strtotime(date("Y-m-01"))); ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Panel -->
                </div>  
            <?php //} ?>
            
            <div class="col-md-12 col-xs-12">


                <!-- Income Cards -->
                <div class="card g-brd-gray-light-v7 g-mb-30">
                    <header class="media g-pa-15 g-pa-25-30-0--md g-mb-20">
                        <div class="media-body align-self-center">
                            <h3 class="text-uppercase g-font-size-default g-color-black g-mb-8">
                                Record Terbaru
                            </h3>
                        </div>

                        <div class="d-flex align-self-end align-items-center">
                            <span class="g-line-height-1 g-font-weight-300 g-font-size-28 g-color-secondary">
                                <?= date('Y-M-d'); ?>
                            </span>
                        </div>
                    </header>

                    <div class="js-custom-scroll g-height-500 g-pa-15 g-pa-0-30-25--md">
                        <table class="table table-responsive-sm w-100">
                            <thead>
                                <tr>
                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Date</th>
                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Staff</th>
                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Item</th>
                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Start</th>
                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Final</th>
                                    <th class="text-right g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Price</th>
                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none g-pl-20">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //foreach ($fuelSalesRecords as $model) { ?>
                                    <tr>
                                        <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                            <?php // $model->date_issued; ?>
                                        </td>
                                        <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                            <?php // $model->staff->title; ?>
                                        </td>
                                        <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                            <?php // $model->item->title; ?>
                                        </td>
                                        <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                            <?php // number_format($model->start_liter); ?>
                                        </td>
                                        <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                            <?php // number_format($model->final_liter); ?>
                                        </td>
                                        <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                            <?php // number_format($model->sell_price); ?>
                                        </td>
                                        <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">
                                            <?php
//                                                Html::a('<i class="fa fa-eye"></i>',
//                                                    Yii::$app->urlManager->createUrl(['fuel-sales/view', 'id' => $model->id]),
//                                                    [
//                                                        'title' => Yii::t('yii', 'Edit'),
//                                                        'class'=>'btn btn-sm btn-info',
//                                                    ]
//                                                )
                                            ?>
                                        </td>
                                    </tr>
                                <?php //} ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Income Cards -->
        </div>
        <!-- End Income Card -->

    </div>
    
    
    <div class="col-md-12 col-xs-12">
        <div class="js-area-chart u-area-chart--v1 g-pos-rel g-line-height-0" data-height="100px" data-high="2420" data-low="0" data-offset-x="0" data-offset-y="0" data-postfix=" m" data-is-show-area="true" data-is-show-line="false" data-is-show-point="true"
                    data-is-full-width="true" data-is-stack-bars="true" data-is-show-axis-x="false" data-is-show-axis-y="false" data-is-show-tooltips="true" data-tooltip-description-position="left" data-tooltip-custom-class="u-tooltip--v2 g-font-weight-300 g-font-size-default g-color-gray-dark-v6"
                    data-align-text-axis-x="center" data-fill-opacity=".3" data-fill-colors='["#1cc9e4"]' data-stroke-width="2px" data-stroke-color="#1cc9e4" data-stroke-dash-array="0" data-text-size-x="14px" data-text-color-x="#000000" data-text-offset-top-x="0"
                    data-text-size-y="14px" data-text-color-y="#53585e" data-points-colors='["#1cc9e4"]' data-series='[
                [
                  {"meta": "$", "value": 400},
                  {"meta": "$", "value": 2400},
                  {"meta": "$", "value": 700},
                  {"meta": "$", "value": 2750},
                  {"meta": "$", "value": 600},
                  {"meta": "$", "value": 1840},
                  {"meta": "$", "value": 320},
                  {"meta": "$", "value": 2720},
                  {"meta": "$", "value": 800}
                ]
            ]' data-labels='["2013", "2014", "2015", "2016", "2017"]'>
        </div>
    </div>
    
</div>

