<?php
use yii\helpers\Html;
use backend\models\Article as Blog;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- CALL TO ACTION -->
<div class="row">
    <div class="col-md-6">

        <div class="box-header with-border">
            <h3 class="box-title">CALL TO ACTION</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$callToAction_Caption->id],['class'=>'pull-right']);?>
                    <?=$callToAction_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">

        <div class="box-header with-border">
            <h3 class="box-title">BUTTON</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$callToAction_Text->id],['class'=>'pull-right']);?>
                    <?=$callToAction_Text->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$callToAction_Link->id],['class'=>'pull-right']);?>
                    <?=$callToAction_Link->content;?>
                </li>
            </ul>
        </div>
    </div>
</div>