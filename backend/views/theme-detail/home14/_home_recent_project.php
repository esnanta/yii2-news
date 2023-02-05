<?php
use yii\helpers\Html;
use backend\models\Product as Product;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- RECENT PROJECT -->
<div class="row">
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">RECENT PROJECT</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourRecent_Header->id],['class'=>'pull-right']);?>
                    <?=$ourRecent_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourRecent_Caption->id],['class'=>'pull-right']);?>
                    <?=$ourRecent_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>

    <?php
        foreach ($products as $i => $productModel) {
    ?>
        <div class="col-md-3">
            <?=Html::img($productModel->getCoverUrl(), ['class' => 'img-responsive', 'alt'=>'Image description']);?>
            <?=$productModel->title;?>
            <?=$productModel->description;?>
        </div>
    <?php
        }
    ?>


</div>