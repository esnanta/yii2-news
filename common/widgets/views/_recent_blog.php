<?php
use yii\helpers\Html;
?>

<?php foreach($blogs as $blogModel): ?>
    <div class="blog-thumb blog-thumb-circle margin-bottom-15">
        <div class="blog-thumb-hover">
            
            <?php
                $imageUrl       = (empty($blogModel->author_id)) ? $blogModel->getDefaultAuthorImage() : $blogModel->author->getImageUrl();
                $authorImage    = str_replace('frontend', 'backend', $imageUrl);            
                echo Html::img($authorImage, ['class'=>'rounded-x'],['alt' => 'alt image']);
            ?>            
            
            <?= 
                (empty($blogModel->author_id)) ? '': Html::a('<i class="fa fa-link"></i>', $blogModel->author->getUrl(),['class'=>'hover-grad']); 
            ?>
            
        </div>
        <div class="blog-thumb-desc">
            <h3><?= Html::a(Html::encode($blogModel->title), $blogModel->getUrl()); ?></h3>
            <ul class="blog-thumb-info">
                <li><?= Yii::$app->formatter->format($blogModel->created_at, 'date'); ?></li>
                <li><?= $blogModel->category->title; ?></li>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
