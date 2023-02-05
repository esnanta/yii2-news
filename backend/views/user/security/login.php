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



<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <?php 
                $tmpHome    = Html::a('<i class="fa fa-home"></i> Home ', ['site/index'], ['class' => 'logo']);
                $home    = str_replace('user/', '', $tmpHome);
            ?>
            <b><?= str_replace('admin/', '', $home) ?></b>            
        </div>
        
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ]) ?>                 
            
            
                <div class="form-group has-feedback">
                    
                    <?php if ($module->debug): ?>
                        <?= $form->field($model, 'login', [
                            'inputOptions' => [
                                'autofocus' => 'autofocus',
                                'class' => 'form-control',
                                'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                        ?>

                    <?php else: ?>

                        <?= $form->field($model, 'login',
                            ['inputOptions' => [
                                'autofocus' => 'autofocus', 
                                'class' => 'form-control', 
                                'tabindex' => '1',
                                'placeholder'=>'Email'
                            ]]
                        );
                        ?>

                    <?php endif ?>                 
                </div>
            
                <div class="form-group has-feedback">
                    
                    
                    <?php if ($module->debug): ?>
                        <div class="alert alert-warning">
                            <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                        </div>
                    <?php else: ?>
                        <?= $form->field(
                            $model,
                            'password',
                            ['inputOptions' => [
                                'class' => 'form-control', 
                                'tabindex' => '2',
                                'placeholder'=>'Password'
                            ]])
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
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            
                            <?= 
                                $form->field($model, 'rememberMe')
                                ->checkbox([
                                    'tabindex' => '3',
                                ]) 
                            ?>                               
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <?= Html::submitButton(
                            Yii::t('user', 'Sign in'),
                            ['class' => 'btn btn-primary btn-block btn-flat', 'tabindex' => '4']
                        ) ?>                         
                    </div>
                    <!-- /.col -->
                </div>
            

            <?php ActiveForm::end(); ?>
            
            <?= ($module->enablePasswordRecovery) ?
                        str_replace('backend', 'frontend', Html::a('Forgot password?', ['/user/recovery/request'])) :
                        '';
            ?>
            <br>
            <?php if ($module->enableRegistration): ?>
        
                    <?= str_replace('backend', 'frontend',Html::a(Yii::t('user', 'Register a new membership'), ['/user/registration/register'])) ?>
             
            <?php endif ?>                    
            <br>
            <?php if ($module->enableConfirmation): ?>
                <br>
                <?= "Didn't receive confirmation message? ". str_replace('backend', 'frontend',Html::a(Yii::t('user', 'resend'), ['/user/registration/resend'])) ?>
            <?php endif ?>
            <br>
            <?= Connect::widget([
                'baseAuthUrl' => ['/user/security/auth'],
            ]) ?>             
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
</div>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>




