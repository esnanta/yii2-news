<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$img = Html::img(str_replace('frontend', 'backend', $model->getAssetUrl()),
                ['class' => 'img-fluid rounded-circle w-100']);
?>

<div class="row">
    <div class="col-lg-4 g-mb-40 g-mb-0--lg">
        <!-- User Image -->
        <div class="g-mb-20">
            <?=$img;?>
        </div>
        <!-- User Image -->

        <!-- User Contact Buttons -->
<!--        <a class="btn btn-block u-btn-outline-primary g-rounded-50 g-py-12 g-mb-10" href="#">
            <i class="icon-user-follow g-pos-rel g-top-1 g-mr-5"></i> Follow Me
        </a>
        <a class="btn btn-block u-btn-darkgray g-rounded-50 g-py-12 g-mb-10" href="#">
            <i class="icon-call-in g-pos-rel g-top-1 g-mr-5"></i> Contact Me
        </a>-->
        <!-- End User Contact Buttons -->
    </div>
    <div class="col-lg-8">
        <!-- User Details -->

        <div class="d-flex align-items-center justify-content-sm-between g-mb-5">
            <h2 class="g-font-weight-300 g-mr-10"><?= $model->title; ?></h2>
            <ul class="list-inline mb-0">
                <?php $staffMedias = $dataProviderSocial->models; ?>

                <?php foreach ($staffMedias as $staffMediaItem) : ?>
                    <li class="list-inline-item g-mx-2">
                        <?= Html::a(
                            '<i class="g-font-size-default g-line-height-1 u-icon__elem-regular fa fa-twitter"></i>' .
                            '<i class="g-font-size-default g-line-height-0_8 u-icon__elem-hover ' . $staffMediaItem->title . '"></i>',
                            $staffMediaItem->description,
                            ['class' => 'u-icon-v1 u-icon-size--sm u-icon-slide-up--hover g-color-gray-light-v1 g-bg-gray-light-v5 g-color-gray-light-v1--hover rounded-circle']
                        ) ?>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
        <!-- End User Details -->

        <!-- User Position -->
        <h4 class="h6 g-font-weight-300 g-mb-10">
            <i class="icon-user g-pos-rel g-top-1 g-mr-5 g-color-gray-dark-v5"></i>
            <?= (!empty($model->employment_id)) ? $model->employment->title:'Not Set';?>
        </h4>
        <!-- End User Position -->

        <!-- User Info -->
        <ul class="list-inline g-font-weight-300">
            <li class="list-inline-item g-mr-20">
                <i class="icon-location-pin g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> 
                <?= (!empty($model->address)) ? $model->address : '-'; ?>
            </li>
            <li class="list-inline-item g-mr-20">
                <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> 
                Active : <?= $model->getOneActiveStatus($model->active_status); ?>
            </li>
            <li class="list-inline-item g-mr-20">
                <i class="icon-phone g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i>  
                <?= (!empty($model->phone_number)) ? $model->phone_number : '-'; ?>
            </li>
        </ul>
        <!-- End User Info -->

        <hr class="g-brd-gray-light-v4 g-my-20">

        <p class="lead g-line-height-1_8">
            <?= (!empty($model->description)) ? $model->description : 'Description :-'; ?>
        </p>

        <hr class="g-brd-gray-light-v4 g-my-20">

        <div class="card border-0 rounded-0">
            <!-- Panel Header -->
            <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                <h3 class="h6 mb-0">
                    <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> User Accounts
                </h3>
            </div>
            <!-- End Panel Header -->

            <!-- Panel Body -->
            
            <div class="js-scrollbar card-block u-info-v1-1 g-bg-white-gradient-v1--after g-height-300 g-pa-0">
                <ul class="list-unstyled">
                    <?php if(!empty($model->twitter)) { ?>
                        <li class="d-flex justify-content-between g-brd-bottom g-brd-gray-light-v4 g-py-10 g-px-15">
                            <span class="text-nowrap g-mr-10"><i class="fa fa-twitter g-color-twitter g-pos-rel g-top-1 g-mr-10"></i> Twitter</span>
                            <?= Html::a($model->twitter, 'https://twitter.com/'.$model->twitter, ['class' => 'g-color-twitter']) ?>
                        </li>
                    <?php } ?>
                        
                    <?php if(!empty($model->instagram)) { ?>
                        <li class="d-flex justify-content-between g-brd-bottom g-brd-gray-light-v4 g-py-10 g-px-15">
                            <span class="text-nowrap g-mr-10"><i class="fa fa-instagram g-color-instagram g-pos-rel g-top-1 g-mr-10"></i> Instagram</span>
                            <?= Html::a($model->instagram, 'https://instagram.com/'.$model->instagram, ['class' => 'g-color-instagram']) ?>
                        </li>
                    <?php } ?>
                    
                    <?php if(!empty($model->facebook)) { ?>
                        <li class="d-flex justify-content-between g-brd-bottom g-brd-gray-light-v4 g-py-10 g-px-15">
                            <span class="text-nowrap g-mr-10"><i class="fa fa-facebook g-color-facebook g-pos-rel g-top-1 g-mr-10"></i> Facebook</span>
                            <?= Html::a($model->facebook, 'https://facebook.com/'.$model->facebook, ['class' => 'g-color-facebook']) ?>
                        </li>
                    <?php } ?>
                        
                    <?php if(!empty($model->google_plus)) { ?>    
                        <li class="d-flex justify-content-between g-brd-bottom g-brd-gray-light-v4 g-py-10 g-px-15">
                            <span class="text-nowrap g-mr-10"><i class="fa fa-google g-color-lightred g-pos-rel g-top-1 g-mr-10"></i> Google Plus</span>
                            <a class="g-color-lightred g-color-lightred--hover" href="#"><?=$model->google_plus;?></a>
                        </li>
                    <?php } ?>
                        
                    <?php if(!empty($model->email)) { ?>      
                        <li class="d-flex justify-content-between g-brd-bottom g-brd-gray-light-v4 g-py-10 g-px-15">
                            <span class="text-nowrap g-mr-10"><i class="fa fa-envelope g-color-lightred g-pos-rel g-top-1 g-mr-10"></i> Gmail</span>
                            <a class="g-color-lightred g-color-lightred--hover" href="#"><?=$model->email;?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- End Panel Body -->
        </div>
        
        
        <!-- Experience Timeline -->
<!--        <div class="card border-0 rounded-0 g-mb-40">
             Panel Header 
            <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                <h3 class="h6 mb-0">
                    <i class="icon-briefcase g-pos-rel g-top-1 g-mr-5"></i> Experience
                </h3>
                <div class="dropdown g-mb-10 g-mb-0--md">
                    <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-options-vertical g-pos-rel g-top-1"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Projects
                        </a>
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-wallet g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Wallets
                        </a>
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-fire g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Reports
                        </a>
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-settings g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Users Setting
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
                        </a>
                    </div>
                </div>
            </div>
             End Panel Header 

             Panel Body 
            <div class="js-scrollbar card-block u-info-v1-1 g-bg-white-gradient-v1--after g-height-300 g-pa-0">
                <ul class="row u-timeline-v2-wrap list-unstyled">
                    <li class="col-md-12 g-brd-bottom g-brd-0--md g-brd-gray-light-v4 g-pb-30 g-pb-0--md g-mb-30 g-mb-0--md">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">Project Manager</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2016 - Current</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">Pixeel Ltd.</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                    <li class="col-md-12 g-brd-bottom g-brd-0--md g-brd-gray-light-v4 g-pb-30 g-pb-0--md g-mb-30 g-mb-0--md">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">Full Stack Developer</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2014 - 2016</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">Htmlstream</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                    <li class="col-md-12 g-brd-bottom g-brd-0--md g-brd-gray-light-v4 g-pb-30 g-pb-0--md g-mb-30 g-mb-0--md">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">Frontend Developer</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2012 - 2014</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">Amazon Inc.</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                    <li class="col-md-12">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">UX/UI Designer</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2010 - 2012</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">Apple Inc.</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                </ul>
            </div>
             End Panel Body 
        </div>-->
        <!-- End Experience Timeline -->

        <!-- Education Timeline -->
<!--        <div class="card border-0 rounded-0 g-mb-40">
             Panel Header 
            <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                <h3 class="h6 mb-0">
                    <i class="icon-graduation g-pos-rel g-top-1 g-mr-5"></i> Education
                </h3>
                <div class="dropdown g-mb-10 g-mb-0--md">
                    <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-options-vertical g-pos-rel g-top-1"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Projects
                        </a>
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-wallet g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Wallets
                        </a>
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-fire g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Reports
                        </a>
                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-settings g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Users Setting
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item g-px-10" href="#">
                            <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
                        </a>
                    </div>
                </div>
            </div>
             End Panel Header 

             Panel Body 
            <div class="js-scrollbar card-block u-info-v1-1 g-bg-white-gradient-v1--after g-height-300 g-pa-0">
                <ul class="row u-timeline-v2-wrap list-unstyled">
                    <li class="col-md-12 g-brd-bottom g-brd-0--md g-brd-gray-light-v4 g-pb-30 g-pb-0--md g-mb-30 g-mb-0--md">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">MBA</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2008 - 2010</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">Imperial College London</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                    <li class="col-md-12 g-brd-bottom g-brd-0--md g-brd-gray-light-v4 g-pb-30 g-pb-0--md g-mb-30 g-mb-0--md">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">Bachelor of IT</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2004 - 2008</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">MIT University</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                    <li class="col-md-12 g-brd-bottom g-brd-0--md g-brd-gray-light-v4 g-pb-30 g-pb-0--md g-mb-30 g-mb-0--md">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">High School</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2001 - 2004</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">Chicago High School</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                    <li class="col-md-12">
                        <div class="row">
                             Timeline Date 
                            <div class="col-md-3 align-self-center text-md-right g-pr-40--md g-mb-20 g-mb-0--md">
                                <h4 class="h5 g-font-weight-300">Elementary School</h4>
                                <h5 class="h6 g-font-weight-300 mb-0">2001 - 1992</h5>
                            </div>
                             End Timeline Date 

                             Timeline Content 
                            <div class="col-md-9 align-self-center g-orientation-left g-pl-40--md">
                                 Timeline Dot 
                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                    <i class="d-block g-width-18 g-height-18 g-bg-primary g-brd-around g-brd-4 g-brd-gray-light-v4 rounded-circle"></i>
                                </div>
                                 End Timeline Dot 

                                <article class="g-pa-10--md">
                                    <h3 class="h4 g-font-weight-300">New York Elementary School</h3>
                                    <p class="mb-0">Winter purslane courgette pumpkin quandong komatsuna fennel green bean cucumber. Pea cress potato sprouts wattle seed rutabaga.</p>
                                </article>
                            </div>
                             End Timeline Content 
                        </div>
                    </li>
                </ul>
            </div>
             End Panel Body 
        </div>-->
        <!-- End Education Timeline -->

    </div>
</div>



