<?php
use yii\helpers\Html;
use backend\models\Article as Blog;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- LATEST NEWS -->
<div class="row">
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">LATEST NEWS</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourLatest_Header->id],['class'=>'pull-right']);?>
                    <?=$ourLatest_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourLatest_Caption->id],['class'=>'pull-right']);?>
                    <?=$ourLatest_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>


    <?php
                    foreach ($blogs as $i => $blogModel) {
                ?>
    <div class="col-md-4">
        <div class="box-body">
            <?=Html::img($blogModel->getCover($blogModel->content), ['class' => 'img-responsive', 'alt'=>'Image description']);?>
            <?= Html::a($blogModel->title, $blogModel->getUrl()) ?>
            <?=$blogModel->readMore(100);?>
        </div>
    </div>
    <?php
                    }
                ?>


</div>