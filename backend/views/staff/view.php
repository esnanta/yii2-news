<?php

use common\helper\UIHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = UIHelper::getCreateButton();
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

                    <?= Html::a('<i class="hs-admin-pencil g-absolute-centered g-font-size-16 g-color-white"></i>', ['/staff/update', 'id' => $model->id], ['class' => 'u-badge-v2--lg u-badge--bottom-right g-width-32 g-height-32 g-bg-secondary g-bg-primary--hover g-transition-0_3 g-mb-20 g-mr-20']); ?>

                    <img class="img-fluid rounded-circle" src="<?= $model->getAssetUrl() ?>" alt="<?= $model->title; ?>">
                </div>

                <h3 class="g-font-weight-300 g-font-size-20 g-color-black mb-0"><?= Html::a($model->title, ['/staff/update', 'id' => $model->id,]); ?></h3>
            </section>
            <!-- User Information -->

            <!-- Profile Sidebar -->
            <section>
                <ul class="list-unstyled mb-0">
                    <li class="g-brd-top g-brd-gray-light-v7 mb-0">

                        <a class="d-flex align-items-center u-link-v5 g-parent g-py-15 active" href="">
                                <span class="g-font-size-18 g-color-gray-light-v6 g-color-primary--parent-hover g-color-primary--parent-active g-mr-15">
                                    <i class="hs-admin-email"></i>
                                </span>
                            <span class="g-color-gray-dark-v6 g-color-primary--parent-hover g-color-primary--parent-active">
                                    <?= (!empty($model->email)) ? $model->email : '-' ?>
                                </span>
                        </a>
                    </li>
                    <li class="g-brd-top g-brd-gray-light-v7 mb-0">
                        <a class="d-flex align-items-center u-link-v5 g-parent g-py-15" href="">
                                <span class="g-font-size-18 g-color-gray-light-v6 g-color-primary--parent-hover g-color-primary--parent-active g-mr-15">
                                    <i class="hs-admin-tablet"></i>
                                </span>
                            <span class="g-color-gray-dark-v6 g-color-primary--parent-hover g-color-primary--parent-active">
                                    <?= (!empty($model->phone_number)) ? $model->phone_number : '-'; ?>
                                </span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- Profile Sidebar -->
        </div>
    </div>

    <div class="col-md-9">

        <div id="nav-1-1-dark-hor-right" class="tab-content">
            <div class="tab-pane fade show active" id="nav-1-1-dark-hor-right--1" role="tabpanel">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'condensed' => false,
                    'hover' => true,
                    'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                    'panel' => [
                        'heading' => $this->title . $create,
                        'type' => DetailView::TYPE_DEFAULT,
                    ],
                    'attributes' => [
                        [
                            'columns' => [
                                [
                                    'attribute' => 'title',
                                    'valueColOptions'=>['style'=>'width:30%']
                                ],
                                [
                                    'attribute' => 'office_id',
                                    'value' => ($model->office_id != null) ? $model->office->title : '',
                                    'format' => 'html',
                                    'type' => DetailView::INPUT_SELECT2,
                                    'options' => ['id' => 'office_id', 'prompt' => '', 'disabled' => (Yii::$app->user->identity->isAdmin) ? false : true],
                                    'items' => $officeList,
                                    'widgetOptions' => [
                                        'class' => Select2::class,
                                        'data' => $officeList,
                                    ],
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'employment_id',
                                    'value' => ($model->employment_id != null) ? $model->employment->title : '',
                                    'type' => DetailView::INPUT_SELECT2,
                                    'options' => ['id' => 'employment_id', 'prompt' => '', 'disabled' => false],
                                    'items' => $employmentList,
                                    'widgetOptions' => [
                                        'class' => Select2::class,
                                        'data' => $employmentList,
                                    ],
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'active_status',
                                    'value' => ($model->active_status != null) ? $model->getOneActiveStatus($model->active_status) : '',
                                    'format' => 'html',
                                    'type' => DetailView::INPUT_SELECT2,
                                    'options' => ['id' => 'active_status', 'prompt' => '', 'disabled' => false],
                                    'items' => $activeStatusList,
                                    'widgetOptions' => [
                                        'class' => Select2::class,
                                        'data' => $activeStatusList,
                                    ],
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'phone_number',
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'gender_status',
                                    'value' => ($model->gender_status != null) ? $model->getOneGenderStatus($model->gender_status) : '',
                                    'format' => 'html',
                                    'type' => DetailView::INPUT_SELECT2,
                                    'options' => ['id' => 'gender_status', 'prompt' => '', 'disabled' => false],
                                    'items' => $genderList,
                                    'widgetOptions' => [
                                        'class' => Select2::class,
                                        'data' => $genderList,
                                    ],
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'initial',
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'email',
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],

                        [
                            'group' => true,
                            'rowOptions' => ['class' => 'default']
                        ],
                        [
                            'attribute' => 'address',
                            'format' => 'html',
                            'type' => DetailView::INPUT_TEXTAREA,
                            //'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute' => 'description',
                            'format' => 'html',
                            'type' => DetailView::INPUT_TEXTAREA,
                            //'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute' => 'file_name',
                            'type' => DetailView::INPUT_HIDDEN,
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
                                    'value' => ($model->created_by != null) ? \common\models\User::getName($model->created_by) : '',
                                    'type' => DetailView::INPUT_HIDDEN,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                                [
                                    'attribute' => 'updated_by',
                                    'value' => ($model->updated_by != null) ? \common\models\User::getName($model->updated_by) : '',
                                    'type' => DetailView::INPUT_HIDDEN,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ],
                            ],
                        ],
                    ],
                    'deleteOptions' => [
                        'url' => ['delete', 'id' => $model->id],
                    ],
                    'enableEditMode' => Yii::$app->user->can('update-staff'),
                ])
                ?>
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