<?php
use yii\helpers\Html;
?>


<ul class="list-inline blog-photostream margin-bottom-50">
    
    <?php 
        foreach($models as $photoModel): 
            $imageUrl   = str_replace('frontend', 'backend', $photoModel->getImageUrl());
            $img        = Html::img($imageUrl, ['class'=>'img-responsive','style'=>'width:80px;height:50px']);
            $link       = Html::a('<span>'.$img.'</span>', $imageUrl,['class'=>'fancybox img-hover-v2','rel'=>'gallery','title'=>$photoModel->title]);
    ?>

            <li>
                <?= $link; ?>
            </li>            
  
    <?php endforeach; ?>      
    

</ul>
