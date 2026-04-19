<?php

use common\helpers\ContentHelper;
use yii\helpers\Html;

$defaultCoverUrl = \Yii::getAlias('@web/themes/bootstrap4news/assets/img/news-350x223-1.jpg');

?>

<?php foreach($articleList as $model): ?>
    <div class="nl-item">
        <div class="nl-img">
            <?php
            $bodyHtml = $model->body ?? $model->content ?? null;
            $coverUrl = ContentHelper::resolveCoverUrl(
                $model->thumbnail_base_url ?? null,
                $model->thumbnail_path ?? null,
                $bodyHtml,
                $defaultCoverUrl
            ) ?? $defaultCoverUrl;
            ?>
            <?= Html::img($coverUrl,['width'=>'100','height'=>'60']);?>
        </div>
        <div class="nl-title">
            <?= Html::a($model->title, $model->getUrl());?>
        </div>
    </div>
<?php endforeach; ?>
