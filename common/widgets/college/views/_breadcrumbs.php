<?php
    use yii\helpers\Html;
?>

<div class="breadcrumbs float-right">
    <ul class="breadcrumbs-list">
        <li class="breadcrumbs-label"><?= Html::a('Home', ['site/index']); ?> <i class="fas fa-angle-right"></i></li>
        <li><?=$indexTitle;?> <i class="fas fa-angle-right"></i></li>
        <li class="current"><?= $pageTitle; ?></li>
    </ul>
</div><!--//breadcrumbs-->