<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Album $model
 */

$this->title = 'Update Password ' . ' ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['/profile/view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Profile        </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="album-update">

            <?= $this->render('_account', [
                'user' => $user,
            ]) ?>

        </div>
        
    </div>
</div>

