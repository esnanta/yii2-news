<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap4\ActiveForm; // Already using Bootstrap 4 ActiveForm
use yii\bootstrap4\Nav;       // Already using Bootstrap 4 Nav
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?= $this->render('/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

    <?= $this->render('_menu') ?>

    <div class="row mt-4"> <!-- Added mt-4 for top margin -->
        <div class="col-md-3">
            <div class="card"> <!-- Replaced panel panel-default with card -->
                <div class="card-body"> <!-- Replaced panel-body with card-body -->
                    <?= Nav::widget([
                        'options' => [
                            'class' => 'nav-pills flex-column', // Replaced nav-stacked with flex-column for Bootstrap 4
                        ],
                        'items' => [
                            ['label' => Yii::t('user', 'Account details'), 'url' => ['/user/admin/create']],
                            [
                                'label' => Yii::t('user', 'Profile details'),
                                'options' => [
                                    'class' => 'disabled', // This applies 'disabled' to the <li>
                                ],
                                'linkOptions' => [ // Added linkOptions to apply 'disabled' to the <a> tag
                                    'class' => 'disabled',
                                    'tabindex' => '-1',
                                    'aria-disabled' => 'true',
                                    'onclick' => 'return false;', // Kept onclick to prevent navigation
                                ]
                            ],
                            [
                                'label' => Yii::t('user', 'Information'),
                                'options' => [
                                    'class' => 'disabled', // This applies 'disabled' to the <li>
                                ],
                                'linkOptions' => [ // Added linkOptions to apply 'disabled' to the <a> tag
                                    'class' => 'disabled',
                                    'tabindex' => '-1',
                                    'aria-disabled' => 'true',
                                    'onclick' => 'return false;', // Kept onclick to prevent navigation
                                ]
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card"> <!-- Replaced panel panel-default with card -->
                <div class="card-body"> <!-- Replaced panel-body with card-body -->
                    <div class="alert alert-info">
                        <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
                        <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
                    </div>
                    <?php $form = ActiveForm::begin([
                        'layout' => 'horizontal',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-3', // Explicitly define label column width for horizontal forms
                                'offset' => 'offset-sm-3', // Define offset for horizontal forms
                                'wrapper' => 'col-sm-9',
                                'error' => '',
                                'hint' => '',
                            ],
                        ],
                    ]); ?>

                    <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

                    <div class="form-group row"> <!-- Added 'row' class for proper horizontal form alignment -->
                        <div class="offset-lg-3 col-lg-9"> <!-- Replaced col-lg-offset-3 with offset-lg-3 -->
                            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
