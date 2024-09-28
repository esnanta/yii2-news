<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

$articleCover   = str_replace('frontend', 'backend',
    ContentHelper::getCover($model->content));
$label  = ($model->articleCategory->label) ? $model->articleCategory->label:'darkpurple';
?>



<article class="u-block-hover">
    <?php if(substr($articleCover, 0, 2)=='//'){ ?>
            <iframe 
                allowfullscreen="" 
                frameborder="0" 
                src="<?=$articleCover;?>?controls=0" 
                width="359"
                height="249" 
                >
            </iframe>
    
    <?php } else{ ?>
    
            <figure class="u-shadow-v25 g-bg-cover g-bg-white-gradient-opacity-v1--after">                           
                <?=Html::img($articleCover, ['class' => 'img-fluid w-100 u-block-hover__main--zoom-v1', 'style' => 'width:369px;height:249px']);?>
            </figure>
    
    <?php } ?>             


    <div class="w-100 text-center g-absolute-centered g-px-30">
        <?php 
            $linkClassLabel = "btn btn-xs u-btn-".$label." text-uppercase rounded-0";
            echo Html::a($model->articleCategory->title, 
                    ['blog/index',
                        'cat'=>$model->article_category_id,
                        'title'=>$model->articleCategory->title], 
                    ['class' => $linkClassLabel]) ;
        ?>
        
        <h3 class="h4 g-my-10 g-bg-black-opacity-0_6 g-px-5">
            <?= Html::a($model->title, $model->getUrl(), ['class' => 'g-color-white g-color-white--hover']) ?>  
        </h3>
        <small class="g-color-white">
            <i class="icon-clock g-pos-rel g-top-1 g-mr-2"></i> <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
        </small>
    </div>
</article>
