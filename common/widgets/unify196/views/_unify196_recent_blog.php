<?php
use yii\helpers\Html;
?>

<ul class="list-unstyled blog-latest-posts margin-bottom-50">
    
    <?php foreach($blogs as $blogModel): ?>

        <li>
            <h3><?= Html::a(Html::encode($blogModel->title), $blogModel->getUrl()); ?></h3>
            <small>
                <?= Yii::$app->formatter->format($blogModel->created_at, 'date'); ?> 
                / 
                <?= $blogModel->category->title.' '.$blogModel->getLabel(); ?>
            </small>
            <p><?= $blogModel->readMore(); ?></p>
        </li>    
  
    <?php endforeach; ?>       

</ul>
<!-- End Latest Links -->
