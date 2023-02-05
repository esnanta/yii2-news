<?php
use yii\helpers\Html;
$unset = '#NA';
?>

<?php 
    $src = str_replace('frontend', 'backend', $model->getCover($model->content));
    $vid = '';
    if (strpos($src, 'iframe') !== false) {
        echo $vid=$scr;
    }  
    
    $modulo = ($index+1) % 2;
    $class  = ($modulo==false) ? 'timeline-inverted':'""';
?>


    <div class="timeline-badge primary"><i class="glyphicon glyphicon-record"></i></div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <?= Html::img($src, ['class' => 'img-responsive img-thumbnail', 'style' => 'width:408px;height:258px']) ?>
        </div>
        <div class="timeline-body text-justify">
            <h3><?= Html::a($model->title, $model->getUrl()); ?></h3>
            <p><?= strip_tags($model->readMore()); ?></p>
        </div>
        <div class="timeline-footer">
            <ul class="list-unstyled list-inline blog-info">
                <li><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->format($model->created_at, 'date'); ?></li>
            </ul>
            <a class="likes" href="#"><i class="fa fa-eye"></i><?= $model->view_counter; ?></a>
        </div>
    </div>
