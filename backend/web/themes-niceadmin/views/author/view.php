<?php

use common\helper\IconHelper;
use kartik\detail\DetailView;
use common\helper\LabelHelper;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
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
                <span><?= (!empty($model->email)) ? $model->email : '-' ?></span>
                <span><?= (!empty($model->phone_number)) ? $model->phone_number : '-'; ?></span>
                <div class="social-links mt-2">
                    <?php
                    foreach ($dataProviderSocial->getModels() as $key => $authorMedia) {
                        $title = $authorMedia->title;
                        $href = $authorMedia->description;
                        $class = IconHelper::getOneFontAwesomeBrands($authorMedia->title);
                        ?>
                        <a href="<?= $href ?>" class="<?= $class; ?>"><i class="<?= $title; ?>"></i></a>
                    <?php } ?>
                </div>
                <div class="pt-2 float-end">
                    <?=
                    Html::a(IconHelper::getUpload(), ['author/update', 'id' => $model->id, 'title' => $model->title],
                        ['class' => 'btn btn-primary btn-sm', 'title' => 'Upload new profile image?'])
                    ?>
                    <?=
                    Html::a(IconHelper::getDelete(), ['author/delete-file', 'id' => $model->id],
                        ['class' => 'btn btn-danger btn-sm', 'data-confirm' => "Delete File?",
                            'data-method' => 'POST', 'title' => 'Delete File?'])
                    ?>
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
                                data-bs-target="#profile-overview">
                            <?=Yii::t('app', 'Profile')?>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#profile-media-social">
                            <?=Yii::t('app', 'Social')?>
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