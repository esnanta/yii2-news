<?php

use common\helper\IconHelper;
use common\helper\LabelHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var common\models\StaffMedia $dataProviderSocial
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = LabelHelper::getCreateButton();
?>


<div class="row">
    <div class="col-xl-3">

        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="<?= $model->getAssetUrl() ?>" alt="Profile" class="rounded-circle img-fluid">
                <br>
                <h5><?= $model->title ?></h5>
                <span><?= $model->employment->title ?></span>
                <span><?= (!empty($model->email)) ? $model->email : '-' ?></span>
                <span><?= (!empty($model->phone_number)) ? $model->phone_number : '-'; ?></span>
                <div class="social-links mt-2">
                    <?php
                    foreach ($dataProviderSocial->getModels() as $key => $staffMediaItem) {
                        $title = $staffMediaItem->title;
                        $href = $staffMediaItem->description;
                        $class = IconHelper::getOneFontAwesomeBrands($staffMediaItem->title);
                        ?>
                        <a href="<?= $href ?>" class="<?= $class; ?>"><i class="<?= $title; ?>"></i></a>
                    <?php } ?>
                </div>
                <div class="pt-2 float-end">
                    <a href="<?= Url::to(['/staff/update', 'id' => $model->id ,'title'=>$model->title]);?>"
                       class="btn btn-primary btn-sm"
                       title="Upload new profile image">
                        <i class="bi bi-upload"></i>
                    </a>
                    <a href="#"
                       class="btn btn-danger btn-sm"
                       title="Remove my profile image">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active"
                                data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Profile
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#profile-media-social">Social
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview"
                         id="profile-overview">

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
                                            'valueColOptions' => ['style' => 'width:30%']
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

                    <div class="tab-pane fade profile-edit pt-3"
                         id="profile-media-social">
                        <?php
                        echo $this->render('index_media',
                            [
                                'model' => $model,
                                'dataProvider' => $dataProviderSocial,
                                'mediaType' => $mediaType
                            ]
                        );
                        ?>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>

    </div>
</div>