<?php
use yii\helpers\Html;
use backend\models\Profile;

$profile        = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
                    
$profileId      = (!empty($profile) ? $profile->user_id : '#' );  
$profileName    = (!empty($profile) ? $profile->name : 'Guest' );
$profileImage   = (!empty($profile) ? $profile->getImageUrl() : '' );

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <?php 
        $home = Html::a('<span class="logo-mini">APP</span><span class="logo-lg"><i class="fa fa-home"></i> Home </span>', ['site/index'], ['class' => 'logo']);
    ?>
    
    <?= str_replace('admin/', '', $home) ?>


    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->

                <?php if (!empty($profile)){ ?>
                
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= $profileImage ?>" class="user-image" alt="User Image"/>
                            <span class="hidden-xs"><?= $profileName ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= $profileImage ?>" class="img-circle"
                                     alt="User Image"/>

                                <p>
                                    <?= $profileName ?>
                                    <!--<small>Member since Nov. 2012</small>-->
                                </p>
                            </li>
                            <!-- Menu Body -->
    <!--                        <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li>-->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= Html::a(
                                        'Profile',
                                        ['/profile/view','id'=>$profileId],
                                        ['class'=>'btn btn-default btn-flat']
                                    ) ?>                                
                                    <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                                </div>
                                <div class="pull-right">
                                    <?= Html::a(
                                        'Password',
                                        ['/admin/update','id'=>Yii::$app->user->id],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    
                <?php } ?>
                    
                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <?= Html::a(
                        '<i class="fa fa-recycle"></i> ',
                        ['/site/flush'],
                        ['data-method' => 'post','title'=>'Flush Cache']
                    ) ?>                    
                    
                </li>                 
                <li>
                    <?= Html::a(
                        '<i class="fa fa-sign-out"></i> ',
                        ['/site/logout'],
                        ['data-method' => 'post','title'=>'Sign Out']
                    ) ?>                    
                    
                </li>
            </ul>
        </div>
    </nav>
</header>
