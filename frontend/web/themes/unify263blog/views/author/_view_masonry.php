
<?php

use common\helper\ContentHelper;
use yii\helpers\Html;
?>

<?php 
    $src = str_replace('frontend', 'backend', $model->getCover($model->content));
    $vid = '';
    if (strpos($src, 'iframe') !== false) {
        echo $vid=$scr;
    }  
?>
<?php 
    if ($vid <> '') {
?>
    <div class="embed-responsive embed-responsive-16by9 full-width" style="width:120px;height:75px">
        <iframe src="<?php echo $vid; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    </div>
<?php
    } 
    else {
        echo Html::img($src, ['class' => 'img-responsive img-thumbnail', 'style' => 'width:260px;height:175px']);
    }
?>        


<h3><small><?= Html::a($model->title, $model->getUrl()); ?></small></h3>

<p><?= strip_tags(ContentHelper::readMore($model->content)); ?></p>

<?php Html::a('Read More', $model->getUrl(),['class'=>'r-more'])?>
