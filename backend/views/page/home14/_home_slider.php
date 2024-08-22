<?php
use yii\helpers\Html;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- REVOLUTION SLIDER -->

<div class="row">
    <div class="col-md-6">
        <div class="box-header with-border">
            <h3 class="box-title">Revolution Slider 1</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$slider1_Header->id],['class'=>'pull-right']);?>
                    <?= $slider1_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$slider1_Image->id],['class'=>'pull-right']);?>
                    <?= Html::img($slider1_Image->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$slider1_Caption->id],['class'=>'pull-right']);?>
                    <?= $slider1_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box-header with-border">
            <h3 class="box-title">Revolution Slider 1</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$slider2_Header->id],['class'=>'pull-right']);?>
                    <?= $slider2_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$slider2_Image->id],['class'=>'pull-right']);?>
                    <?= Html::img($slider2_Image->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$slider2_Caption->id],['class'=>'pull-right']);?>
                    <?= $slider2_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>
</div>