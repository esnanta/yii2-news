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

<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-0">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-5">

                            <?php
                            $tmpHome = Html::a('<i class="fa fa-home"></i> Back To Home ',
                                ['site/index']);
                            $home = str_replace('user/', '', $tmpHome);
                            ?>

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                Sign in to start your session <br>
                                <small>or <?= $home ?></small>
                            </div>

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
                                        'class' => 'form-control form-control-user',
                                        'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                                ?>

                            <?php else: ?>

                                <?=
                                $form->field($model, 'login',
                                    ['inputOptions' => [
                                        'autofocus' => 'autofocus',
                                        'class' => 'form-control form-control-user',
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
                                        'class' => 'form-control form-control-user',
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


                            <?php
                            $form->field($model, 'rememberMe')
                                ->checkbox([
                                    'tabindex' => '3',
                                    'class' => 'custom-control custom-checkbox small',
                                    'labelOptions' => ['class' => 'form-check-inline u-check g-pl-25'],
                                ])->label('')
                            ?>

                            <?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?>
                            <?= Html::label('Show password', 'reveal-password') ?>

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
                    <div class="col-lg-6 d-none d-lg-block"
                         style="background: url(<?=Yii::$app->urlManager->baseUrl.'/themes-sbadmin2/assets/img/20944201.jpg'?>) center;
                         background-size:cover">
<!--                        <small><a href="http://www.freepik.com">Designed by vectorjuice / Freepik</a></small>-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(
    "jQuery('#reveal-password')
            .change(function(){jQuery('#login-form-password')
            .attr('type',this.checked?'text':'password');})"
);
?>