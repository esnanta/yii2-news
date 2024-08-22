<?php
use yii\helpers\Url;
use common\models\User;

use common\helper\MessageHelper;


?>
<div class="g-pos-rel g-hidden-sm-down">
    <a id="notificationsInvoker" class="d-block text-uppercase u-header-icon-v1 g-pos-rel g-width-40 g-height-40 rounded-circle g-font-size-20" href="#" aria-controls="notificationsMenu" aria-haspopup="true" aria-expanded="false" data-dropdown-event="click"
       data-dropdown-target="#notificationsMenu" data-dropdown-type="css-animation" data-dropdown-duration="300" data-dropdown-animation-in="fadeIn" data-dropdown-animation-out="fadeOut">
        <i class="hs-admin-bell g-absolute-centered"></i>
    </a>

    <!-- Top Notifications List -->
    <div id="notificationsMenu" class="js-custom-scroll g-absolute-centered--x g-width-340 g-max-width-400 g-height-400 g-mt-17 rounded" aria-labelledby="notificationsInvoker">
        <div class="media text-uppercase u-header-dropdown-bordered-v1 g-pa-20">
            <h4 class="d-flex align-self-center g-font-size-default g-letter-spacing-0_5 g-mr-20 g-mb-0">Notifications</h4>
        </div>

        <ul class="p-0 mb-0">
            <!-- Top Notifications List Item -->
            <?php //foreach ($fuelSalesRecords as $model) {?>
                
                <li class="media u-header-dropdown-item-v1 g-parent g-px-20 g-py-15">
                    <div class="d-flex align-self-center u-header-dropdown-icon-v1 g-pos-rel g-width-55 g-height-55 g-font-size-22 rounded-circle g-mr-15">
                        <i class="fa fa-bell-o g-absolute-centered"></i>
                    </div>

                    <div class="media-body align-self-center">
                        <p class="mb-0">
                            Start liter <?php //number_format($model->start_liter);?> <br>
                            final liter <?php // number_format($model->final_liter);?> <br>
                            <em class="d-flex align-self-center align-items-center g-font-style-normal g-color-lightblue-v2">
                                <i class="hs-admin-time icon-clock g-mr-5"></i> 
                                <small>
                                    <?php // MessageHelper::getTimeElapsedString($model->created_at);?>
                                </small>
                            </em>
                            
                        </p>
                    </div>

                   
                    
                    <a class="d-flex g-color-lightblue-v2 g-font-size-12 opacity-1 g-opacity-1--parent-hover g-transition--ease-in g-transition-0_2" 
                       href="<?php // Url::to(['/fuel-sales/view','id'=>$model->id])?>">
                        by <?php // User::getName($model->staff->user_id)?>
                    </a>
                </li>
            <?php //} ?>
            <!-- End Top Notifications List Item -->
        </ul>
    </div>
    <!-- End Top Notifications List -->
</div>
