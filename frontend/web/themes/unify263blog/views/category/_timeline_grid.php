<?php
use yii\helpers\Html;
?>

<?php
    $src = str_replace('frontend', 'backend', $model->getCover($model->content));
    $vid = '';
    if (strpos($src, 'iframe') !== false) {
        echo $vid=$scr;
    }

    $modulo = ($index+1) % 2;
    $leftRight = ($modulo==false) ? 'left':'right';
?>

<?php if($leftRight=='right'){?>

    <div class="col-md-6 g-orientation-right g-pl-60 g-pl-15--md g-pr-40--md g-mb-60 g-mb-0--md">
        <div class="u-timeline-v1__icon g-color-gray-light-v5 g-ml-13 g-ml-minus-10--md">
            <i class="fa fa-circle"></i>
        </div>

        <div class="g-pos-rel">
            <!-- Timeline Arrow -->
            <div class="g-hidden-sm-down u-triangle-inclusive-v1--left g-top-30 g-z-index-2">
                <div class="u-triangle-inclusive-v1--left__front g-brd-white-left g-brd-white-right"></div>
                <div class="u-triangle-inclusive-v1--left__back g-brd-gray-light-v4-left g-brd-gray-light-v4-right"></div>
            </div>

            <div class="g-hidden-md-up u-triangle-inclusive-v1--right g-top-30 g-z-index-2">
                <div class="u-triangle-inclusive-v1--right__front g-brd-white-right"></div>
                <div class="u-triangle-inclusive-v1--right__back g-brd-gray-light-v4-right"></div>
            </div>
            <!-- End Timeline Arrow -->

            <!-- Timeline Content -->
            <article class="u-timeline-v1 g-pa-5">
                <figure class="g-pos-rel">
                    <?= Html::img($src, ['class' => 'img-fluid w-100']) ?>

                    <figcaption class="g-pos-abs g-top-20 g-left-20">
                        <?= Html::a($model->category->title,
                                ['/blog/index','cat'=>$model->category_id,'title'=>$model->category->title],
                                ['class' => 'btn btn-sm u-btn-red rounded-0']);
                        ?>
                    </figcaption>
                </figure>

                <div class="g-py-25 g-px-20">
                    <h3 class="g-font-weight-300 g-mb-15">
                        <?= Html::a($model->title, $model->getUrl(),['class'=>'u-link-v5 g-color-main g-color-primary--hover']); ?>
                    </h3>

                    <div class="g-mb-30">
                        <p> <?= strip_tags($model->readMore()); ?> </p>
                    </div>

                    <hr class="g-brd-gray-light-v4">

                    <div class="media g-font-size-12">
                        <?= Html::img($model->author->getImageUrl(), ['class' => 'd-flex mr-3 rounded-circle g-width-30 g-height-30']) ?>
                        <div class="media-body align-self-center text-uppercase">
                            <?= Html::a($model->author->title, $model->author->getUrl(), ['class' => 'u-link-v5 g-color-main g-color-primary--hover']) ?>
                        </div>

                        <div class="align-self-center">
                            <span class="u-link-v5 g-color-main g-color-primary--hover g-mr-10">
                                <i class="fa fa-clock-o"></i>
                                <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                            </span>
                            <span class="u-link-v5 g-color-main g-color-primary--hover">
                                <i class="icon-eye g-mr-2"></i>
                                <?= $model->view_counter; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </article>
            <!-- End Timeline Content -->
        </div>
    </div>

<?php } else if($leftRight=='left'){ ?>

    <div class="col-md-6 g-orientation-left g-pl-60 g-pl-40--md g-mt-60--md g-mb-60 g-mb-0--md">
        <div class="u-timeline-v1__icon g-color-gray-light-v5 g-mr-13 g-mr-minus-8--md">
            <i class="fa fa-circle"></i>
        </div>

        <div class="g-pos-rel">
            <!-- Timeline Arrow -->
            <div class="u-triangle-inclusive-v1--right g-top-30 g-z-index-2">
                <div class="u-triangle-inclusive-v1--right__front g-brd-white-right"></div>
                <div class="u-triangle-inclusive-v1--right__back g-brd-gray-light-v4-right"></div>
            </div>
            <!-- End Timeline Arrow -->

            <!-- Timeline Content -->
            <article class="u-timeline-v1 g-pa-5">
                <figure class="g-pos-rel">
                    <?= Html::img($src, ['class' => 'img-fluid w-100']) ?>

                    <figcaption class="g-pos-abs g-top-20 g-right-20">
                        <?= Html::a($model->category->title,
                                ['/blog/index','cat'=>$model->category_id,'title'=>$model->category->title],
                                ['class' => 'btn btn-sm u-btn-red rounded-0']);
                        ?>
                    </figcaption>
                </figure>

                <div class="g-py-25 g-px-20">
                    <h3 class="g-font-weight-300 g-mb-15">
                        <?= Html::a($model->title, $model->getUrl(),['class'=>'u-link-v5 g-color-main g-color-primary--hover']); ?>
                    </h3>

                    <div class="g-mb-30">
                        <p> <?= strip_tags($model->readMore()); ?> </p>
                    </div>

                    <hr class="g-brd-gray-light-v4">

                    <div class="media g-font-size-12">
                        <?= Html::img($model->author->getImageUrl(), ['class' => 'd-flex mr-3 rounded-circle g-width-30 g-height-30']) ?>
                        <div class="media-body align-self-center text-uppercase">
                            <?= Html::a($model->author->title, $model->author->getUrl(), ['class' => 'u-link-v5 g-color-main g-color-primary--hover']) ?>
                        </div>

                        <div class="align-self-center">
                            <span class="u-link-v5 g-color-main g-color-primary--hover g-mr-10">
                                <i class="fa fa-clock-o"></i>
                                <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                            </span>
                            <span class="u-link-v5 g-color-main g-color-primary--hover">
                                <i class="icon-eye g-mr-2"></i>
                                <?= $model->view_counter; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </article>
            <!-- End Timeline Content -->
        </div>
    </div>
<?php } ?>