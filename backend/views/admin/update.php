<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Album $model
 */

$this->title = 'Update Password ' . ' ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['/profile/view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="card border-default mb-3">
    <div class="card-header">
        <?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right float-end">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-secondary">
        <div class="card-text">
            <?= $this->render('_account', [
                'user' => $user,
            ]) ?>
        </div>
    </div>
</div>
