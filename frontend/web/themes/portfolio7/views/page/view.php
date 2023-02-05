<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;

/**
 * @var yii\web\View $this
 * @var backend\models\Page $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
    //$model->content = $model->configureContentImage();
?>

<div class="blog-grid margin-bottom-30 breadcrumbs">
    <h2 class="blog-grid-title-lg"><?php echo $model->title; ?></h2>
    <div class="overflow-h">
        <ul class="blog-grid-info pull-left">
            <li><i class="fa fa-address-book"></i> <?php echo 'Page'; ?></li>
            <li><?php echo $model->pageType->title; ?></li>
            <li><?php echo Yii::$app->formatter->format($model->updated_at, 'date'); ?></li>
        </ul>
        <div class="pull-right">
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <div class="addthis_sharing_toolbox"></div>
        </div>
    </div>  
</div>

<p>
    <div style="font-size: 14px">
        <?php
            //BIASANYA PURIFY ADALAH TRUE. TAPI GAK BISA UNTUK NAMPILIN VIDEO
            //$this->beginWidget('CMarkdown', array('purifyOutput' => false));
            echo $model->content;
            //$this->endWidget();
        ?>       
    </div>    
</p>


