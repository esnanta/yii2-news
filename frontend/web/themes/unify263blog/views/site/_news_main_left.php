<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

$articleCover   = str_replace('frontend', 'backend',
    ContentHelper::getCover($model->content));
$image  = Html::img($articleCover, ['class' => 'img-fluid w-100']);
$label  = ($model->articleCategory->label) ? $model->articleCategory->label:'darkpurple';    
?>


<article>

    <?php if(substr($articleCover, 0, 2)=='//'){ ?>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe 
                class="embed-responsive-item" 
                src="<?=$articleCover;?>?controls=0" 
                allowfullscreen>     
            </iframe>
        </div>

    <?php } else{ ?>
    
            <figure class="u-shadow-v25 g-pos-rel g-mb-20">
                <?= Html::a($image, $model->getUrl()) ?>
                <figcaption class="g-pos-abs g-top-20 g-left-20"> 
                    <?php 
                        $linkClassLabel = "btn btn-xs u-btn-".$label." text-uppercase rounded-0";
                        echo Html::a($model->articleCategory->title, 
                                ['blog/index',
                                    'cat'=>$model->article_category_id,
                                    'title'=>$model->articleCategory->title], 
                                ['class' => $linkClassLabel]) ;
                    ?>
                </figcaption>
            </figure>
    
    <?php } ?>   
    


    <h3 class="h4 g-mb-10">
        <?= Html::a($model->title, $model->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v1 g-color-primary--hover']) ?>
    </h3>

    <ul class="list-inline g-color-gray-dark-v4 g-font-size-12">
        <li class="list-inline-item">
            <?= Html::a($model->author->title, $model->author->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v4 g-color-primary--hover']) ?>
        </li>
        <li class="list-inline-item">/</li>
        <li class="list-inline-item">
            <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
        </li>
        <li class="list-inline-item">/</li>
        <li class="list-inline-item">
            <i class="icon-eye u-line-icon-pro align-middle g-pos-rel g-top-1 mr-1"></i>
            <?=$model->view_counter;?>
        </li>
    </ul>

    <span class="g-color-gray-dark-v2"><?= strip_tags(ContentHelper::readMore($model->content)); ?></span>
    <br>
    <?= Html::a('Read More...', $model->getUrl(), ['class' => 'g-font-size-12']) ?>

</article>