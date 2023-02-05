<?php
use yii\helpers\Html;
?>

<?php foreach($blogs as $model): ?>

    <!-- Article -->
    <article class="media g-mb-30">

        <?php
            $imageUrl       = (empty($model->author_id)) ? $model->getDefaultAuthorImage() : $model->author->getImageUrl();
            $authorImage    = str_replace('frontend', 'backend', $imageUrl);  
            $styledIamge    = Html::img($authorImage, ['class'=>'d-flex u-shadow-v25 g-width-60 g-height-60 rounded-circle g-mr-20'],['alt' => 'alt image']);
            echo Html::a($styledIamge, $model->getUrl());
        ?>              

        <div class="media-body">
            <h3 class="h6">
                <?= Html::a(Html::encode($model->title), $model->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v1 g-color-primary--hover']); ?>
            </h3>

            <ul class="u-list-inline g-font-size-12 g-color-gray-dark-v4">
                <li class="list-inline-item">
                    <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                </li>
                <li class="list-inline-item">/</li>
                <li class="list-inline-item">
                    <span class="g-color-gray-dark-v4 g-text-underline--none--hover">
                        <i class="icon-eye u-line-icon-pro align-middle g-pos-rel g-top-1 mr-1"></i> 
                        <?=$model->view_counter;?>
                    </span>
                </li>
            </ul>
        </div>
    </article>
    <!-- End Article -->
<?php endforeach; ?>
