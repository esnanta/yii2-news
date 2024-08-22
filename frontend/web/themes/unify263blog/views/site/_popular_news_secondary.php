<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

$articleCover   = str_replace('frontend', 'backend',
    ContentHelper::getCover($model->content));
$image  = Html::img($articleCover, ['class' => 'g-width-140 g-height-80']);
$label  = ($model->articleCategory->label) ? $model->articleCategory->label:'darkpurple';    
?>

<div class="col-lg-6 g-mb-50 g-mb-0--lg">
    <hr class="g-brd-gray-light-v4 g-my-25">

    <!-- Other Articles -->
    <article class="media">
        
        <?php if(substr($articleCover, 0, 2)=='//'){ ?>
                <iframe 
                    class ="mr-3"
                    allowfullscreen="" 
                    frameborder="0" 
                    width="140"
                    height="80" 
                    src="<?=$articleCover;?>?controls=0" 
                >
                </iframe>
        <?php } else{ ?>
                <figure class="d-flex u-shadow-v25 mr-3 g-pos-rel">
                    <?= Html::a($image, $model->getUrl()) ?>
                </figure>
        <?php } ?>
        
        
        


        <div class="media-body">
            <h3 class="g-font-size-16">
                <?= Html::a($model->title, $model->getUrl(), ['class' => 'g-color-gray-dark-v1']) ?>
            </h3>

            <ul class="u-list-inline g-font-size-12 g-color-gray-dark-v4">
                <li class="list-inline-item">
                    <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                </li>
                <li class="list-inline-item">/</li>
                <li class="list-inline-item">
                    <i class="icon-eye g-pos-rel g-top-1 g-mr-2"></i> 
                    <?= $model->view_counter; ?>
                </li>
            </ul>
        </div>
    </article>
    <!-- End Other Articles -->

</div>