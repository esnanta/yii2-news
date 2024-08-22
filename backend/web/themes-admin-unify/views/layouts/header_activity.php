<?php

$firstDate  =date("Y-m-01");
$endDate    =date("Y-m-t");

$fuelSalesRecords = '';

?>
<div id="activityMenu" class="js-custom-scroll u-header-sidebar g-pos-fix g-top-0 g-left-auto g-right-0 g-z-index-4 g-width-300 g-width-400--sm g-height-100vh" aria-labelledby="activityInvoker">
    <div class="u-header-dropdown-bordered-v1 g-pa-20">
        <a id="activityInvokerClose" class="pull-right g-color-lightblue-v2" href="#" aria-controls="activityMenu" aria-haspopup="true" aria-expanded="false" data-dropdown-event="click" data-dropdown-target="#activityMenu" data-dropdown-type="css-animation" data-dropdown-animation-in="fadeInRight"
           data-dropdown-animation-out="fadeOutRight" data-dropdown-duration="300">
            <i class="hs-admin-close"></i>
        </a>
        <h4 class="text-uppercase g-font-size-default g-letter-spacing-0_5 g-mr-20 g-mb-0">Activity</h4>
    </div>

    <!-- Activity Short Stat. -->
    <section class="g-pa-20">
        <div class="media align-items-center u-link-v5 g-color-white">
            <div class="media-body align-self-center g-line-height-1_3 g-font-weight-300 g-font-size-40">
                1
                <span class="g-font-size-16"> / rec </span>
            </div> 

            <div class="d-flex align-self-center g-font-size-20 g-line-height-1 g-color-secondary ml-auto">
                -
            </div>

            <div class="d-flex align-self-center g-ml-8">
                <svg class="g-fill-white-opacity-0_5" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
                <svg class="g-fill-lightblue-v3" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g transform="translate(-33.000000, -751.000000)">
                        <g transform="translate(0.000000, 64.000000)">
                            <g transform="translate(20.000000, 619.000000)">
                                <g transform="translate(1.000000, 68.000000)">
                                    <polygon transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)" points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
        </div>

        <span class="g-font-size-16">Transactions</span>
    </section>
    <!-- End Activity Short Stat. -->

<!--     Activity Bars 
    <section class="g-pa-20 g-mb-10">
         Advertising Income 
        <div class="g-mb-30">
            <div class="media u-link-v5  g-color-white g-mb-10">
                <span class="media-body align-self-center">Advertising Income</span>

                <span class="d-flex align-self-center">
                    <svg class="g-fill-white-opacity-0_5" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
                    <svg class="g-fill-lightblue-v3" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g transform="translate(-33.000000, -751.000000)">
                            <g transform="translate(0.000000, 64.000000)">
                                <g transform="translate(20.000000, 619.000000)">
                                    <g transform="translate(1.000000, 68.000000)">
                                        <polygon transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)" points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
            </div>

            <div class="progress g-height-4 g-bg-gray-light-v8 g-rounded-2">
                <div class="progress-bar g-bg-teal-v2 g-rounded-2" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
         End Advertising Income 

         Projects Income 
        <div class="g-mb-30">
            <div class="media u-link-v5  g-color-white g-mb-10">
                <span class="media-body align-self-center">Projects Income</span>
                <span class="d-flex align-self-center">
                    <svg class="g-fill-red" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
                    <svg class="g-fill-white-opacity-0_5" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g transform="translate(-33.000000, -751.000000)">
                            <g transform="translate(0.000000, 64.000000)">
                                <g transform="translate(20.000000, 619.000000)">
                                    <g transform="translate(1.000000, 68.000000)">
                                        <polygon transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)" points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
            </div>

            <div class="progress g-height-4 g-bg-gray-light-v8 g-rounded-2">
                <div class="progress-bar g-bg-lightblue-v3 g-rounded-2" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
         End Projects Income 

         Template Sales 
        <div>
            <div class="media u-link-v5  g-color-white g-mb-10">
                <span class="media-body align-self-center">Template Sales</span>
                <span class="d-flex align-self-center">
                    <svg class="g-fill-white-opacity-0_5" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
                    <svg class="g-fill-lightblue-v3" width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g transform="translate(-33.000000, -751.000000)">
                            <g transform="translate(0.000000, 64.000000)">
                                <g transform="translate(20.000000, 619.000000)">
                                    <g transform="translate(1.000000, 68.000000)">
                                        <polygon transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)" points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
            </div>

            <div class="progress g-height-4 g-bg-gray-light-v8 g-rounded-2">
                <div class="progress-bar g-bg-darkblue-v2 g-rounded-2" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
         End Template Sales 
    </section>
     End Activity Bars -->

    <!-- Activity Accounts -->
    <section class="g-pa-20">
        <h5 class="text-uppercase g-font-size-default g-letter-spacing-0_5 g-mb-10">
                <?= date('F',strtotime($firstDate)); ?>
        </h5>

        <div class="media u-header-dropdown-bordered-v2 g-py-10">
            <div class="d-flex align-self-center g-mr-12">
                <span class="u-badge-v2--sm g-pos-stc g-transform-origin--top-left g-bg-teal-v2"></span>
            </div>

            <div class="media-body align-self-center">Liter Terjual</div>

            <div class="d-flex text-right">
                <?php //number_format($fuelSalesRecords->sum('liters_sold')).' L';?>
            </div>
        </div>

        <div class="media u-header-dropdown-bordered-v2 g-py-10">
            <div class="d-flex align-self-center g-mr-12">
                <span class="u-badge-v2--sm g-pos-stc g-transform-origin--top-left g-bg-lightblue-v3"></span>
            </div>

            <div class="media-body align-self-center">Dana Masuk</div>

            <div class="d-flex text-right"><?php // 'Rp. '.number_format($fuelSalesRecords->sum('income_estimate'));?></div>
        </div>

<!--        <div class="media g-py-10">
            <div class="d-flex align-self-center g-mr-12">
                <span class="u-badge-v2--sm g-pos-stc g-transform-origin--top-left g-bg-darkblue-v2"></span>
            </div>

            <div class="media-body align-self-center">Savings Account</div>

            <div class="d-flex text-right">$128.248.000</div>
        </div>-->
    </section>
    <!-- End Activity Accounts -->

    <!-- Activity Transactions -->
    <section class="g-pa-20">
        <h5 class="text-uppercase g-font-size-default g-letter-spacing-0_5 g-mb-10">Transactions</h5>

        <!-- Transaction Item -->
        
        <?php //foreach ($fuelSalesRecords->all() as $model) {?>
            <div class="u-header-dropdown-bordered-v2 g-py-20">
                <div class="media g-pos-rel">
                    <div class="d-flex align-self-start g-pt-3 g-mr-12">
                        <i class="hs-admin-plus g-color-lightblue-v3"></i>
                    </div>

                    <div class="media-body align-self-start">
                        <strong class="d-block g-font-size-17 g-font-weight-400 g-line-height-1">Rp.<?php // number_format($model->income_estimate);?></strong>
                        <p class="mb-0 g-mt-5">on <?php //$model->date_issued;?></p>
                    </div>

                    <em class="d-flex align-items-center g-pos-abs g-top-0 g-right-0 g-font-style-normal g-color-lightblue-v2">
                        <i class="hs-admin-time icon-clock g-font-size-default g-mr-8"></i> <small><?php // MessageHelper::getTimeElapsedString($model->date_issued);?></small>
                    </em>
                </div>
            </div>

        <?php //}; ?>

        <!-- End Transaction Item -->

    </section>
    <!-- End Activity Transactions -->
</div>