<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ArchiveCategory $model */

$this->title = 'Create Archive Category';
$this->params['breadcrumbs'][] = ['label' => 'Archive Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
