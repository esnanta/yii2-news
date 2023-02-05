<?php
use yii\helpers\Html;
?>

<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Coution</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
                echo \kartik\widgets\Growl::widget([
                    'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                    'showSeparator' => true,
                ]);
            ?>
        <?php endforeach; ?>    
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        If problem persists please contact administrator.
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->