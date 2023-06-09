<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'User'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'username',
        'auth_key',
        'password_hash',
        'password_reset_token',
        'email:email',
        'status',
        'last_login',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerAuthor->totalCount){
    $gridColumnAuthor = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'title',
            'phone_number',
            'email:email',
            'google_plus',
            'instagram',
            'facebook',
            'twitter',
            'file_name',
            'address:ntext',
            'description:ntext',
            'is_deleted',
            ['attribute' => 'verlock', 'visible' => false],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAuthor,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tx-author']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Author'),
        ],
        'export' => false,
        'columns' => $gridColumnAuthor
    ]);
}
?>

    </div>
    <div class="row">
        <h4>Profile<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnProfile = [
        'name',
        'public_email',
        'gravatar_email',
        'gravatar_id',
        'location',
        'website',
        'timezone',
        'bio',
        'file_name',
    ];
    echo DetailView::widget([
        'model' => $model->profile,
        'attributes' => $gridColumnProfile    ]);
    ?>
    
    <div class="row">
<?php
if($providerSocialAccount->totalCount){
    $gridColumnSocialAccount = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'provider',
            'client_id',
            'code',
            'email:email',
            'username',
            'data:ntext',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerSocialAccount,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tx-social-account']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Social Account'),
        ],
        'export' => false,
        'columns' => $gridColumnSocialAccount
    ]);
}
?>

    </div>
</div>
