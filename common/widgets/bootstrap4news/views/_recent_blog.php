<?php

use common\helper\ContentHelper;
use yii\helpers\Html;
?>

<?php foreach($blogs as $model): ?>
    <div class="nl-item">
        <div class="nl-img">
            <?= Html::img(ContentHelper::getCover($model->content));?>
        </div>
        <div class="nl-title">
            <?= Html::a($model->title, $model->getUrl());?>
        </div>
    </div>
<?php endforeach; ?>
