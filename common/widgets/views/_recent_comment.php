<?php
use yii\helpers\Html;
?>

<h2 class="title-v4"><?=$title;?></h2>

<?php foreach($comments as $commentModel): ?>

    <div class="blog-thumb-v3">
        <small><?= $commentModel->author; ?></small>
        <h3><?= Html::a(Html::encode($commentModel->blog->title), $commentModel->blog->getUrl()); ?></h3>
    </div>

    <hr class="hr-xs">
<?php endforeach; ?>
