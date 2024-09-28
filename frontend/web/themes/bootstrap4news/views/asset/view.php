<?php

use lesha724\documentviewer\ViewerJsDocumentViewer;
use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Asset $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Asset', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$downloadLinkTmp = Html::a('DOWNLOAD', ['asset/download','id'=>$model->id,'title'=>$model->title],['class'=>'btn btn-md u-btn-primary float-right']);
$downloadLink = str_replace('frontend', 'backend', $downloadLinkTmp);
?>
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title . $downloadLink,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            'title',
            'description:ntext',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]) ?>


    <?php
        if(!empty($model->asset_name)){

            $assetUrl   = $model->getAssetUrl();
            $tmp        = explode('.', $model->asset);
            $ext        = end($tmp);

            if($ext=='jpg'||$ext=='jpeg'||$ext=='png'||$ext=='gif'){
                echo Html::img(str_replace('frontend', 'backend', $assetUrl), ['class' => 'img-fluid']);
    ?>

    <?php
            } else {
                echo ViewerJsDocumentViewer::widget([
                    'url'=> $assetUrl,//url на ваш документ
                    'width'=>'100%',
                    'height'=>'100%',
                ]);
            }
        }
    ?>


