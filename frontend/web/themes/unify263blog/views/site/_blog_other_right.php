<?php
use yii\helpers\Html;

$src    = str_replace('frontend', 'backend', $model->getCover($model->content));    
$image  = Html::img($src, ['class' => 'g-width-80 g-height-60']);
?>

<article class="media">
    
    <?php if(substr($src, 0, 2)=='//'){ ?>
            <iframe 
                class ="mr-3"
                allowfullscreen="" 
                frameborder="0" 
                width="80"
                height="80" 
                src="<?=$src;?>?controls=0" 
            >
            </iframe>
    
    <?php } else{ ?>
    
        <?= Html::a($image, $model->getUrl(), ['class' => 'd-flex u-shadow-v25 align-self-center mr-3']) ?>
    
    <?php } ?>
    
    <div class="media-body">
        <h3 class="h6">
            <?= Html::a($model->title, $model->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v1 g-color-primary--hover']) ?>
        </h3>

        <ul class="u-list-inline g-font-size-12 g-color-gray-dark-v4">
            <li class="list-inline-item">
                <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
            </li>
            <li class="list-inline-item">/</li>
            <li class="list-inline-item">
                <i class="icon-eye u-line-icon-pro align-middle g-pos-rel g-top-1 mr-1"></i>
                <?=$model->view_counter;?>
            </li>
        </ul>
    </div>
</article>

<hr class="g-brd-gray-light-v4 g-my-25">