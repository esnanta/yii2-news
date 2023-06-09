<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ArchiveCategory */

$this->title = 'Create Archive Category';
$this->params['breadcrumbs'][] = ['label' => 'Archive Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
