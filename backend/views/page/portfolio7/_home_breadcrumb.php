<?php
use yii\helpers\Html;
?>

<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////// -->
<!-- HOME GLOBAL -->
<div class="row">
    <div class="col-md-8">
        <div class="box-header with-border">
            <h3 class="box-title">BREADCRUMB</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$breadcrumb_Header->id],['class'=>'pull-right']);?>
                    <?= (empty($breadcrumb_Header->content)) ? 'NA':$breadcrumb_Header->content;?>
                </li>
            </ul>
        </div>

    </div>
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">DATE</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?= Yii::$app->formatter->format(date("Y-m-d"), 'date'); ?>
                </li>
            </ul>
        </div>
    </div>
</div>