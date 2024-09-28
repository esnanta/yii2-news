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
                width="539"
                height="347" 
                >
            </iframe>
    
    <?php } else{ ?>
    
            <figure class="u-shadow-v25 g-bg-cover g-bg-white-gradient-opacity-v1--after">
                <?=Html::img($articleCover, ['class' => 'img-fluid w-100 u-block-hover__main--zoom-v1', 'style' => 'width:554px;height:347px']);?>
            </figure>
    
    <?php } ?>
    
    
    <span class="g-hidden-xs-down g-pos-abs g-top-30 g-left-30">
        <?php 
            $linkClassLabel = "btn btn-xs u-btn-".$label." text-uppercase rounded-0";
            echo Html::a($model->articleCategory->title,
                    ['article/index',
                        'cat'=>$model->article_category_id,
                        'title'=>$model->articleCategory->title],
                    ['class' => $linkClassLabel]) ;
        ?>
    </span>
    
    <div class="g-pos-abs g-bottom-30 g-left-10 g-right-10">
        <h3 class="h4 g-my-10 g-bg-black-opacity-0_6 g-px-5">
            <?= Html::a($model->title, $model->getUrl(), ['class' => 'g-color-white g-color-white--hover']) ?>
        </h3>

        <ul class="g-hidden-xs-down u-list-inline g-font-size-12 g-color-white">
            <li class="list-inline-item">
                <i class="icon-eye g-pos-rel g-top-1 g-mr-2"></i> <?=$model->view_counter;?>
            </li>
            <li class="list-inline-item">/</li>
            <li class="list-inline-item">
                <i class="icon-clock u-line-icon-pro align-middle g-pos-rel g-top-1 g-mr-2"></i>
                <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
            </li>
        </ul>
    </div>
</article>