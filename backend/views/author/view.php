<?php

use common\service\AssetService;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;
use common\helper\LabelHelper;
use common\helper\MediaTypeHelper;
use common\models\User;

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = LabelHelper::getCreateButton();
?>

<ul class="nav justify-content-end u-nav-v1-1 u-nav-dark g-mb-20" role="tablist" data-target="nav-1-1-dark-hor-right"
    data-tabs-mobile-type="slide-up-down"
    data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-darkgray g-mb-20">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav-1-1-dark-hor-right--1" role="tab">
            <?= Yii::t('app', 'Profile'); ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav-1-1-dark-hor-right--2" role="tab">
            <?= Yii::t('app', 'Social'); ?>
        </a>
    </li>
</ul>


<div class="row">
    <div class="col-md-3 g-mb-30 g-mb-0--md">
        <div class="h-100 g-brd-around g-brd-gray-light-v7 g-rounded-4 g-pa-15 g-pa-20--md">
            <!-- User Information -->
            <section class="text-center g-mb-30 g-mb-50--md">
                <div class="d-inline-block g-pos-rel g-mb-20">
                    <a class="u-badge-v2--lg u-badge--bottom-right g-width-32 g-height-32 g-bg-secondary g-bg-primary--hover g-transition-0_3 g-mb-20 g-mr-20"
                       href="#">
                        <i class="hs-admin-pencil g-absolute-centered g-font-size-16 g-color-white"></i>
                    </a>
                    <img class="img-fluid rounded-circle" src="<?= (new common\service\AssetService)->getAssetUrl($model) ?>"
                         alt="<?= $model->title ?>">
                </div>

                <h3 class="g-font-weight-300 g-font-size-20 g-color-black mb-0"><?= $model->title ?></h3>
            </section>
            <!-- User Information -->
        </div>
    </div>

    <div class="col-md-9">

        <div id="nav-1-1-dark-hor-right" class="tab-content">
            <div class="tab-pane fade show active" id="nav-1-1-dark-hor-right--1" role="tabpanel">
                <?= DetailView::widget([
                    'model' => $model,
                    'condensed' => false,
                    'hover' => true,
                    'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                    'panel' => [
                        'heading' => $this->title,
                        'type' => DetailView::TYPE_DEFAULT,
                    ],
                    'buttons1' => '{update}{delete}',
                    'attributes' => [
                        [
                            'attribute' => 'title',
                            //'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'phone_number',
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'email',
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],

                        [
                            'attribute' => 'description',
                            'format' => 'html',
                            'value' => $model->description,
                            'type' => DetailView::INPUT_TEXTAREA,
                        ],

                        [
                            'group' => true,
                            'rowOptions' => ['class' => 'default']
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'created_at',
                                    'format' => 'date',
                                    'type' => DetailView::INPUT_HIDDEN,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'updated_at',
                                    'format' => 'date',
                                    'type' => DetailView::INPUT_HIDDEN,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'created_by',
                                    'value' => ($model->created_by != null) ? User::getName($model->created_by) : '',
                                    'type' => DetailView::INPUT_HIDDEN,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'updated_by',
                                    'value' => ($model->updated_by != null) ? User::getName($model->updated_by) : '',
                                    'type' => DetailView::INPUT_HIDDEN,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],
                    ],
                    'deleteOptions' => [
                        'url' => ['delete', 'id' => $model->id],
                    ],
                    'enableEditMode' => Yii::$app->user->can('update-author'),
                ]) ?>
            </div>
            <div class="tab-pane fade" id="nav-1-1-dark-hor-right--2" role="tabpanel">
                <?php
                    echo $this->render('index_media',
                        [
                            'model'         => $model,
                            'dataProvider'  => $dataProviderSocial,
                            'mediaType'     => $mediaType
                        ]
                    );
                ?>
            </div>
        </div>

    </div>
</div>
