<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Author', 
        'relID' => 'author', 
        'value' => \yii\helpers\Json::encode($model->authors),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'SocialAccount', 
        'relID' => 'social-account', 
        'value' => \yii\helpers\Json::encode($model->socialAccounts),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Username']) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true, 'placeholder' => 'Auth Key']) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'placeholder' => 'Password Hash']) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true, 'placeholder' => 'Password Reset Token']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <?= $form->field($model, 'last_login')->textInput(['placeholder' => 'Last Login']) ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Author'),
            'content' => $this->render('_formAuthor', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->authors),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Profile'),
            'content' => $this->render('_formProfile', [
                'form' => $form,
                'Profile' => is_null($model->profile) ? new backend\models\Profile() : $model->profile,
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('SocialAccount'),
            'content' => $this->render('_formSocialAccount', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->socialAccounts),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
