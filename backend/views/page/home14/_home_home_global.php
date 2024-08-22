<?php
use yii\helpers\Html;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- HOME GLOBAL -->
<div class="row">
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">Logo Atas</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$logoTop->id],['class'=>'pull-right']);?>
                    <?= Html::img($logoTop->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);;?>
                </li>
            </ul>
        </div>

    </div>
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">Description</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$description->id],['class'=>'pull-right']);?>
                    <?= $description->content;?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$keyword->id],['class'=>'pull-right']);?>
                    <?= $keyword->content;?>
                </li>
            </ul>
        </div>
    </div>
</div>