<?php

use common\helper\ContentHelper;
use yii\helpers\Html;

?>

<?php foreach($articleList as $model): ?>
    <div class="nl-item">
        <div class="nl-img">
            <?= Html::img(ContentHelper::getCover($model->content,$model->cover),['width'=>'100','height'=>'60']);?>
        </div>
        <div class="nl-title">
            <?= Html::a($model->title, $model->getUrl());?>
        </div>
    </div>
<?php endforeach; ?>
