<?php
use yii\helpers\Url;
use yii\bootstrap4\Html;

$signOut = '<span class="d-flex align-self-center g-mr-12">
                <i class="hs-admin-shift-right"></i>
            </span>
            <span class="media-body align-self-center">Sign Out</span>';
?>
<div class="col-auto d-flex g-pt-5 g-pt-0--sm g-pl-10 g-pl-20--sm">
    <div class="g-pos-rel g-px-10--lg">
        <a id="profileMenuInvoker" class="d-block" href="#" aria-controls="profileMenu" aria-haspopup="true" aria-expanded="false" data-dropdown-event="click" data-dropdown-target="#profileMenu" data-dropdown-type="css-animation" data-dropdown-duration="300"
           data-dropdown-animation-in="fadeIn" data-dropdown-animation-out="fadeOut">
            <span class="g-pos-rel">
                <span class="u-badge-v2--xs u-badge--top-right g-hidden-sm-up g-bg-secondary g-mr-5"></span>
                <img class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle g-mr-10--sm" 
                     src="<?= $model->getAssetUrl();?>" alt="<?= $model->title;?>">
            </span>
            <span class="g-pos-rel g-top-2">
                <span class="g-hidden-sm-down"><?= $model->title; ?></span>
                <i class="hs-admin-angle-down g-pos-rel g-top-2 g-ml-10"></i>
            </span>
        </a>

        <!-- Top User Menu -->
        <ul id="profileMenu" class="g-pos-abs g-left-0 g-width-100x--lg g-nowrap g-font-size-14 g-py-20 g-mt-17 rounded" aria-labelledby="profileMenuInvoker">
            <li class="g-mb-10">
                <a class="media g-color-primary--hover g-py-5 g-px-20" 
                   href="<?= Url::to(['/staff/view','id'=>$model->id])?>">
                    <span class="d-flex align-self-center g-mr-12">
                        <i class="hs-admin-user"></i>
                    </span>
                    <span class="media-body align-self-center">My Profile</span>
                </a>
            </li>
            
            <li class="mb-0">
                <?= Html::a(
                    $signOut,
                    ['/user/logout'],
                    ['data-method' => 'post', 
                        'data-confirm' => 'Logout now?', 
                        'class' => 'media g-color-primary--hover g-py-5 g-px-20',
                        'title'=>'Sign Out']
                ) ?>  
            </li>
        </ul>
        <!-- End Top User Menu -->
    </div>
</div>