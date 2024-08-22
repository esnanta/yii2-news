<?php
use yii\helpers\Html;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- ABOUT COMPANY -->
<div class="row">
    <div class="col-md-6">

        <div class="box-header with-border">
            <h3 class="box-title">About Company</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourCompany_Header->id],['class'=>'pull-right']);?>
                    <?=$ourCompany_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourCompany_Caption->id],['class'=>'pull-right']);?>
                    <?=$ourCompany_Caption->content;?>
                </li>
            </ul>
        </div>

    </div>
    <div class="col-md-6">
        <div class="box-header with-border">
            <h3 class="box-title">Image</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$ourCompany_Image->id],['class'=>'pull-right']);?>
                    <?= Html::img($ourCompany_Image->getImageUrl(), ['class'=>'img-responsive'],['alt' => 'alt image']);;?>
                </li>
            </ul>
        </div>
    </div>
</div>