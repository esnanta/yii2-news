<?php

/* @var $this yii\web\View */

use backend\models\ThemeDetail as ThemeDetail;
$this->title = 'About';


$model = ThemeDetail::getByToken(Yii::$app->params['ContentToken_About']);
//$modelImg = str_replace('frontend', 'backend', $model->getImageUrl());
?>


<div class="row-fluid privacy">
    <h2><?= $model->title;?></h2>
    <?= $model->content;?>
</div>