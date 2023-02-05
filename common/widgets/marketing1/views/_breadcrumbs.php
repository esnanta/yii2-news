<?php
use yii\helpers\Html;
$imgBackground = Yii::$app->urlManager->baseUrl.'/themes/marketing-home-page-1/img/bg/pattern2.png';
?>

<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url(<?php echo $imgBackground ?>);">
    <div class="container">
        <div class="d-sm-flex text-center">

            <div class="align-self-center">
                <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md"><?= Yii::$app->formatter->format(time(), 'date'); ?></h2>
            </div>

            <div class="align-self-center ml-auto">
                <ul class="u-list-inline">
                    <li class="list-inline-item g-mr-5">
                        <?= Html::a('Home', ['site/index'], ['class' => 'u-link-v5 g-color-main']); ?>
                        <i class="g-color-gray-light-v2 g-ml-5">/</i>
                    </li>
                    <li class="list-inline-item g-mr-5">
                        <?= Html::a($indexTitle, [strtolower($indexTitle).'/index'], ['class' => 'u-link-v5 g-color-main']); ?>
                    </li>
                    
                    <?php if(!empty($pageTitle)){ ?>
                        <li class="list-inline-item g-color-primary">
                            <i class="g-color-gray-light-v2 g-ml-5">/</i>
                            <span><?= $pageTitle; ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</section>

