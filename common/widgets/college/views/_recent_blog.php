<?php
use yii\helpers\Html;
?>

<ul class="list-unstyled g-font-size-13 mb-0">
    <?php foreach($blogs as $blogModel): 
        
            $src = str_replace('frontend', 'backend', $blogModel->getCover($blogModel->content));
    ?>
        <li>
            
            <article class="media g-mb-35">
                <?= Html::img($src, ['class' => 'd-flex g-width-40 g-height-40 rounded-circle mr-3']) ;?>
                <div class="media-body">
                    <h4 class="h6 g-color-black g-font-weight-600"><?= $blogModel->title; ?></h4>
                    <p class="g-color-gray-dark-v4"><?= $blogModel->readMore(); ?></p>
                    <?= Html::a(Html::encode('Read more'), $blogModel->getUrl(),['class'=>'btn u-btn-outline-primary g-font-size-11 g-rounded-25']); ?>
                </div>
            </article>            
            
        </li>    
  
    <?php endforeach; ?>   
        
   
</ul>


