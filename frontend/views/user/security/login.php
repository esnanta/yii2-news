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
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<!-- Login -->
<section class="container g-py-100">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-lg-5">
            <div class="g-brd-around g-brd-gray-light-v4 rounded g-py-40 g-px-30">
                <header class="text-center mb-4">
                    <h2 class="h2 g-color-black g-font-weight-600"><?= Html::encode($this->title) ?></h2>
                </header>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>                
                
                    <!-- Form -->
                    <form class="g-py-15">
                        <div class="mb-4">
                            
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
                                        'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 
                                        'tabindex' => '1',
                                        'placeholder'=>'Email'
                                    ]]
                                );
                                ?>

                            <?php endif ?>                            
                            
                            
                        </div>

                        <div class="g-mb-35">
                            
                            <?php if ($module->debug): ?>
                                <div class="alert alert-warning">
                                    <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                                </div>
                            <?php else: ?>
                                <?= $form->field(
                                    $model,
                                    'password',
                                    ['inputOptions' => [
                                        'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 
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
                            
                            <div class="row justify-content-between">
                                <div class="col align-self-center">
                                    <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-12 g-pl-25 mb-0" style="padding-top:20px">
                                        <?= 
                                            $form->field($model, 'rememberMe')
                                            ->checkbox([
                                                'class'=>'u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0',
                                                'tabindex' => '3',
                                            ]) 
                                        ?>                                           
                                    </label>                                 
                                </div>
                                <div class="col align-self-center text-right">
                                    <?= ($module->enablePasswordRecovery) ?
                                                Html::a('Forgot password?', ['/user/recovery/request'], ['class' => 'g-font-size-12']) :
                                                '';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            
                            <?= Html::submitButton(
                                Yii::t('user', 'Sign in'),
                                ['class' => 'btn btn-md btn-block u-btn-primary g-rounded-50 g-py-13', 'tabindex' => '4']
                            ) ?>                            
                            
                        </div>
                    </form>
                    <!-- End Form -->

                <?php ActiveForm::end(); ?>
                
                
                <footer class="text-center">
                    <?php if ($module->enableRegistration): ?>
                        <p class="g-color-gray-dark-v5 g-font-size-13 mb-0">
                            <?= "Don't have an account? ".Html::a(Yii::t('user', 'signup'), ['/user/registration/register']) ?>
                        </p>
                    <?php endif ?>                    
                    
                    <?php if ($module->enableConfirmation): ?>
                        <p class="g-color-gray-dark-v5 g-font-size-13 mb-0">
                            <?= "Didn't receive confirmation message? ".Html::a(Yii::t('user', 'resend'), ['/user/registration/resend']) ?>
                        </p>
                    <?php endif ?>
                    <?= Connect::widget([
                        'baseAuthUrl' => ['/user/security/auth'],
                    ]) ?>                    
                </footer>
            </div>
        </div>
    </div>
</section>
<!-- End Login -->