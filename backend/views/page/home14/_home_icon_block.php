<?php
use yii\helpers\Html;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- ICON BLOCK -->
<div class="row">
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">Icon Block 1</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock1_Icon->id],['class'=>'pull-right']);?>
                    <?= htmlspecialchars($iconBlock1_Icon->content);?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock1_Header->id],['class'=>'pull-right']);?>
                    <?= $iconBlock1_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock1_Caption->id],['class'=>'pull-right']);?>
                    <?= $iconBlock1_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">Icon Block 2</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock2_Icon->id],['class'=>'pull-right']);?>
                    <?= htmlspecialchars($iconBlock2_Icon->content);?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock2_Header->id],['class'=>'pull-right']);?>
                    <?= $iconBlock2_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock2_Caption->id],['class'=>'pull-right']);?>
                    <?= $iconBlock2_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">Icon Block 3</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock3_Icon->id],['class'=>'pull-right']);?>
                    <?= htmlspecialchars($iconBlock3_Icon->content);?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock3_Header->id],['class'=>'pull-right']);?>
                    <?= $iconBlock3_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$iconBlock3_Caption->id],['class'=>'pull-right']);?>
                    <?= $iconBlock3_Caption->content;?>
                </li>
            </ul>
        </div>
    </div>
</div>