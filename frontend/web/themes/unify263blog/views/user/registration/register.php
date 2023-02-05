<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
//$this->params['breadcrumbs'][] = $this->title;
?>




<!-- Signup -->
<section class="container g-py-100">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-9 col-lg-6">
            <div class="g-brd-around g-brd-gray-light-v4 rounded g-py-40 g-px-30">
                <header class="text-center mb-4">
                    <h2 class="h2 g-color-black g-font-weight-600"><?= Html::encode($this->title) ?></h2>
                </header>

                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>                

                <footer class="text-center">
                    <p class="g-color-gray-dark-v5 g-font-size-13 mb-0">
                        <?= "Already have an account? ".Html::a(Yii::t('user', 'signin'), ['/user/security/login']) ?>
                    </p>                    
                </footer>
            </div>
        </div>
    </div>
</section>
<!-- End Signup -->









