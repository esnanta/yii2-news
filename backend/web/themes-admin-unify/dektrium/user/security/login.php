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



<div class="row">
    <!-- 1-st column -->
    
    <div class="col-md-6 offset-md-3">
        <!-- Checkboxes -->
        <div class="g-brd-around g-brd-gray-light-v7 g-rounded-4 g-pa-15 g-pa-20--md g-mb-30">

            <span class="pull-right">
                <?php
                $tmpHome = Html::a('<i class="fa fa-home"></i> Back To Home ', ['site/index'], ['class' => 'logo']);
                $home = str_replace('user/', '', $tmpHome);
                ?>
                <b><?= str_replace('admin/', '', $home) ?></b>    
            </span>

            <h4 class="h6 g-font-weight-600 g-color-black g-mb-20">Sign in to start your session</h4>

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

            <?php if ($module->debug): ?>
                <?=
                $form->field($model, 'login', [
                    'inputOptions' => [
                        'autofocus' => 'autofocus',
                        'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus g-rounded-4 g-px-14 g-py-10',
                        'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                ?>

            <?php else: ?>

                <?=
                $form->field($model, 'login',
                        ['inputOptions' => [
                                'autofocus' => 'autofocus',
                                'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus g-rounded-4 g-px-14 g-py-10',
                                'tabindex' => '1',
                                'placeholder' => 'Email'
                            ]]
                )->label('Email', ['options' => ['class' => 'g-mb-10']]);
                ?>

            <?php endif ?>                 
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
                                    'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3 g-rounded-4 g-px-14 g-py-10',
                                    'tabindex' => '2',
                                    'placeholder' => 'Password'
                                ]])
                    ->label('Password', ['options' => ['class' => 'g-mb-10']])
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

            
            <?=
                $form->field($model, 'rememberMe')
                ->checkbox([
                    'tabindex' => '3',
                    'class' => 'u-check-icon-checkbox-v4 g-absolute-centered--y g-left-0',
                    'labelOptions' => ['class' => 'form-check-inline u-check g-pl-25'],
                ])->label('')
            ?>   


            <?=
            Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block btn-flat', 'tabindex' => '4']
            )
            ?>   

            <?php ActiveForm::end(); ?>

            <?=
            ($module->enablePasswordRecovery) ?
                    str_replace('backend', 'frontend', Html::a('Forgot password?', ['/user/recovery/request'])) :
                    '';
            ?>
            <br>
            <?php if ($module->enableRegistration): ?>

                <?= str_replace('backend', 'frontend', Html::a(Yii::t('user', 'Register a new membership'), ['/user/registration/register'])) ?>

            <?php endif ?>                    
            <br>
            <?php if ($module->enableConfirmation): ?>
                <br>
                <?= "Didn't receive confirmation message? " . str_replace('backend', 'frontend', Html::a(Yii::t('user', 'resend'), ['/user/registration/resend'])) ?>
            <?php endif ?>
            <br>
            <?=
            Connect::widget([
                'baseAuthUrl' => ['/user/security/auth'],
            ])
            ?>
        </div>
    </div>
</div>