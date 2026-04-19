<?php

/* @var $this yii\web\View */

use common\helpers\MetaHelper;
use common\service\LayoutService;

$this->title = 'About';

MetaHelper::setMetaTags();
$model = LayoutService::getAbout();
?>


<div class="row-fluid privacy">
    <h2><?= $model->title;?></h2>
    <?= $model->content;?>
</div>