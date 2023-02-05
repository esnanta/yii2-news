<?php
use yii\helpers\Html;

?>

<?php
    $img = Html::img(str_replace('frontend', 'backend', $model->getImageUrl()), ['class'=>'img-responsive','style'=>'width:300px;height:300px'],['alt' => 'alt image']);
?>


<div class="cbp-item <?= $model->employment->title;?>">
    <div class="cbp-caption margin-bottom-20">
        <div class="cbp-caption-defaultWrap">
            <?= $img;?>
        </div>
        <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
                <div class="cbp-l-caption-body">
                    <ul class="link-captions no-bottom-space">
                        <li>
                            <?= Html::a('<i class="rounded-x fa fa-link"></i>', ['staff/view','id'=>$model->id], ['class' => '']) ?>                                                              
                        </li>
                        <li>
                            <?= Html::a('<i class="rounded-x fa fa-search"></i>', str_replace('frontend', 'backend', $model->getImageUrl()), [
                                'class' => 'cbp-lightbox',
                                'data-title' => $model->title
                            ]) ?>  
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="cbp-title-dark">
            <div class="cbp-l-grid-agency-title"><?=$model->title?></div>
            <div class="cbp-l-grid-agency-desc"><?=$model->description?></div>
        </div>        
        
    </div>
</div>