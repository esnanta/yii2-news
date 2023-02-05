<?php
use yii\helpers\Html;
$imgBackground = Yii::$app->urlManager->baseUrl.'/themes/home14/img/bg/pattern3.png';
?>


<section class="g-color-white g-bg-gray-dark-v1 g-py-50" style="background-image: url(<?php echo $imgBackground ?>);">
    <div class="container">
        <div class="d-sm-flex text-center">
            <div class="align-self-center">
                <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md"><?= Yii::$app->formatter->format(time(), 'date'); ?></h2>
            </div>

            <div class="align-self-center ml-auto">
                <ul class="u-list-inline">
                    <li class="list-inline-item g-mr-5">
                        <?= Html::a('Home', ['site/index'], ['class' => 'u-link-v5 g-color-white g-color-primary--hover']); ?>
                        <i class="g-color-gray-light-v2 g-ml-5">/</i>
                    </li>
                    <li class="list-inline-item g-mr-5">
                        <?= $indexTitle; ?>
                        <i class="g-color-gray-light-v2 g-ml-5">/</i>
                    </li>
                    <li class="list-inline-item g-color-primary">
                        <span><?= $pageTitle; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

