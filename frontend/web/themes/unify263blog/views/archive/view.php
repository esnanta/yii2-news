<?php
use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Archive $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [        
            //'title',
            'description:ntext',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]) ?>

    
    <?php
        if(!empty($model->file_name)){

            $assetUrl   = $model->getAssetUrl();
            $tmp        = explode('.', $model->asset);
            $ext        = end($tmp);

            if($ext=='jpg'||$ext=='jpeg'||$ext=='png'||$ext=='gif'){
                echo Html::img(str_replace('frontend', 'backend', $assetUrl), ['class' => 'img-fluid']);
    ?>

    <?php
            } else {
                echo \lesha724\documentviewer\ViewerJsDocumentViewer::widget([
                    'url'=> $assetUrl,//url на ваш документ
                    //'url'=> 'www.hubunganinternasional.id/main/admin/uploads/archive/sA9CMQGWN_JbpSHqt2lsIrMLkc9Cxfl6.docx',//url на ваш документ
                    'width'=>'100%',
                    'height'=>'100%',
                    //https://geektimes.ru/post/111647/
                ]);
            }
        }
    ?>
    
    <?php 
        $downloadLink = Html::a('DOWNLOAD', ['archive/download','id'=>$model->id,'title'=>$model->title],['class'=>'btn btn-md u-btn-primary g-mr-10 g-mb-15 pull-right']);
        echo str_replace('frontend', 'backend', $downloadLink);
    ?>
</div>
