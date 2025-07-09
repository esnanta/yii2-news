<?php

/* @var $this yii\web\View */

use common\helper\MetaHelper;
use common\service\PageService;

$this->title = 'About';

MetaHelper::setMetaTags();
$model = PageService::getAbout();
?>


<div class="row-fluid privacy">
    <h2><?= $model->title;?></h2>
    <?= $model->content;?>
</div>