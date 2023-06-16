<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
//$this->params['breadcrumbs'][] = $this->title;

$forgotPassword = Html::a('Forgot password?', ['/user/recovery/request']);
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>



<div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        
                        <?php 
                            $tmpHome    = Html::a('<i class="fa fa-home"></i> Home ', ['site/index'], ['class' => 'logo']);
                            $home    = str_replace('user/', '', $tmpHome);
                        ?>
                        <b><?= str_replace('admin/', '', $home) ?></b>   
                        
                        
                        <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                        </a>

                        <div>
                            <p class="text-center">Your Credentials</p>

                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'login-form',
                                        'enableAjaxValidation' => true,
                                        'enableClientValidation' => false,
                                        'validateOnBlur' => false,
                                        'validateOnType' => false,
                                        'validateOnChange' => false,
                                    ])
                            ?>                 


                            <div class="mb-3">

                                <?php if ($module->debug): ?>
                                    <?=
                                    $form->field($model, 'login', [
                                        'inputOptions' => [
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control',
                                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                                    ?>

                                <?php else: ?>

                                    <?=
                                    $form->field($model, 'login',
                                            ['inputOptions' => [
                                                    'autofocus' => 'autofocus',
                                                    'class' => 'form-control',
                                                    'tabindex' => '1',
                                                    'placeholder' => 'Email'
                                                ]]
                                    )->label('Username',['class'=>'form-label']) ;
                                    ?>

                                <?php endif ?>                 
                            </div>

                            <div class="mb-3">


                                <?php if ($module->debug): ?>
                                    <div class="alert alert-warning">
                                    <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                                    </div>
                                <?php else: ?>
                                    <?=
                                            $form->field(
                                                    $model,
                                                    'password',
                                                    ['inputOptions' => [
                                                            'class' => 'form-control',
                                                            'tabindex' => '2',
                                                            'placeholder' => 'Password'
                                                        ]])
                                            ->label('Password',['class'=>'form-label'])
                                            ->passwordInput()
//                                    ->label(
//                                        Yii::t('user', 'Password')
//                                        . ($module->enablePasswordRecovery ?
//                                            ' (' . Html::a(
//                                                Yii::t('user', 'Forgot password?'),
//                                                ['/user/recovery/request'],
//                                                ['tabindex' => '5']
//                                            )
//                                            . ')' : '')
//                                    ) 
                                    ?>
                                        <?php endif ?>                     
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <?=
                                        $form->field($model, 'rememberMe')->checkbox([
                                            'tabindex' => '3',
                                            'class' => 'form-check-input primary',
                                            'labelOptions' => ['class' => 'form-check-label text-dark'], 
                                        ]);     
                                    ?>  
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-12">
                                    <?= 
                                        Html::submitButton(
                                            Yii::t('user', 'Sign in'),
                                            ['class' => 'btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2', 'tabindex' => '4'])
                                    ?>                         
                                </div>
                                <!-- /.col -->
                            </div>


                            <?php ActiveForm::end(); ?>

                            <?=
                            ($module->enablePasswordRecovery) ?
                                    str_replace('backend', 'frontend', Html::a('Forgot password?', ['/user/recovery/request'])) :
                                    '';
                            ?>
                            <br>
                            <?php if ($module->enableRegistration): ?>

                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                                    <?= str_replace('backend', 'frontend', Html::a(Yii::t('user', 'Register a new membership', ['class'=>'text-primary fw-bold ms-2']),['/user/registration/register'])) ?>
                                </div>
                            <?php endif ?>                    
                            <br>
                            <?php if ($module->enableConfirmation): ?>
                                <br>
                            <?= "Didn't receive confirmation message? " . str_replace('backend', 'frontend', Html::a(Yii::t('user', 'resend'), ['/user/registration/resend'])) ?>
                            <?php endif ?>
                            <br>
                            <?= Connect::widget([
                                'baseAuthUrl' => ['/user/security/auth'],
                                ])
                            ?>             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





