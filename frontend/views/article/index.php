<?php

use frontend\models\search\ArticleSearch;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

/**
 * @var View               $this
 * @var ActiveDataProvider $dataProvider
 * @var ArticleSearch      $searchModel
 * @var array              $categories
 * @var array              $archive
 */
$this->title = Yii::t('frontend', 'Articles');
?>

<h1 class="mt-4">
    <?php echo Yii::t('frontend', 'Articles'); ?>
</h1>

<div class="row">
    <div class="col-sm-8 col-lg-9">
        <?php echo ListView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'hideOnSinglePage' => true,
            ],
            'itemView' => '_item',
            'summaryOptions' => ['class' => ['text-muted mb-3']],
        ]); ?>
    </div>

    <div class="col-sm-4 col-lg-3">
        <?php echo $this->render('_categories', ['categories' => $categories]); ?>
        <?php echo $this->render('_archive', ['archive' => $archive]); ?>
    </div>
</div>
