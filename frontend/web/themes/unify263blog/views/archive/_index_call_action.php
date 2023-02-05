<?php
use yii\helpers\Html;
?>

<!-- Testimonials -->
<div class="media g-brd-bottom g-brd-3 g-brd-gray-light-v4 g-brd-primary--hover g-bg-gray-light-v5 g-rounded-4 g-transition-0_3 g-pa-20">
    <div class="media-body">
        <h4 class="h6 g-font-weight-700 g-mb-0"><?= Html::a($model->title, $model->getUrl()); ?></h4>
        <br>
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
                        'height'=>'300px',
                        //https://geektimes.ru/post/111647/
                    ]);
                }
            }
        ?>
        <p><?= $model->description; ?></p>

        <hr class="g-brd-gray-light-v4 g-my-15">
        <div class="row">
            <div class="col-md-8">
                <!-- Contact Info -->
                <ul class="list-unstyled g-font-size-13 g-color-gray-dark-v4">
                    <li class="g-mb-5">
                        <i class="fa fa-calendar g-mr-10"></i>
                        <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                    </li>
                    <li class="g-mb-5">
                        <i class="fa fa-download g-mr-10"></i>
                        <?= (empty($model->download_counter)) ? 0 : $model->download_counter;?>
                    </li>
                </ul>
                <!-- End Contact Info -->                 
            </div>
            <div class="col-md-4">
                <?= Html::a('DOWNLOAD', ['archive/download','id'=>$model->id,'title'=>$model->title],['class'=>'btn btn-md u-btn-primary g-mr-10 g-mb-15 pull-right']); ?>
            </div>            
        </div>
    </div>
</div>
<!-- End Testimonials -->
    
