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
            <h3 class="box-title">MAIN</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$portfolio7_Header->id],['class'=>'pull-right']);?>
                    <?= (empty($portfolio7_Header->content)) ? 'NA':$portfolio7_Header->content;?>
                </li>
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$portfolio7_Title->id],['class'=>'pull-right']);?>
                    <?= (empty($portfolio7_Title->content)) ? 'NA':$portfolio7_Title->content;?>
                </li>    
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view','id'=>$portfolio7_Caption->id],['class'=>'pull-right']);?>
                    <?= (empty($portfolio7_Caption->content)) ? 'NA':$portfolio7_Caption->content;?>
                </li>                 
            </ul>
        </div>

    </div>
    <div class="col-md-4">
        <div class="box-header with-border">
            <h3 class="box-title">OFFICE</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled">
                <li class="list-group-item">
                    <?=Html::a('<i class="fa fa-eye"></i>', ['/office/view','id'=>$office->id],['class'=>'pull-right']);?>
                    <?= (empty($office->title)) ? 'TITLE?':$office->title;?>
                </li>
                <li class="list-group-item">
                    <?= (empty($office->address)) ? 'ADDRESS?':$office->address;?>
                </li>      
                <li class="list-group-item">
                    <?= (empty($office->email)) ? 'EMAIL?':$office->email;?>
                </li>    
                <li class="list-group-item">
                    <?= (empty($office->phone_number)) ? 'PHONE NUMBER?':$office->phone_number;?>
                </li>                    
            </ul>
        </div>
    </div>
</div>