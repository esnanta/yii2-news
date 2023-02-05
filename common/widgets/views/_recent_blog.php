<?php
use yii\helpers\Html;
?>

<h2 class="title-v4"><?=$title;?></h2>

<?php foreach($blogs as $blogModel): ?>
    <div class="blog-thumb blog-thumb-circle margin-bottom-15">
        <div class="blog-thumb-hover">
            
            <?=
                $img = Html::img(str_replace('frontend', 'backend', $blogModel->author->getImageUrl()), ['class'=>'rounded-x'],['alt' => 'alt image']);
            ?>            
            
            <?= Html::a('<i class="fa fa-link"></i>', $blogModel->author->getUrl(),['class'=>'hover-grad']); ?>
            
        </div>
        <div class="blog-thumb-desc">
            <h3><?= Html::a(Html::encode($blogModel->title), $blogModel->getUrl()); ?></h3>
            <ul class="blog-thumb-info">
                <li><?= Yii::$app->formatter->format($blogModel->create_time, 'date'); ?></li>
                <li><?= $countComments; ?></li>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
