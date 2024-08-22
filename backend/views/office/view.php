<?php

use common\helper\MediaTypeHelper;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Office $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<ul class="nav justify-content-end u-nav-v1-1 u-nav-dark g-mb-20" role="tablist" data-target="nav-1-1-dark-hor-right" data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-darkgray g-mb-20">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav-1-1-dark-hor-right--1" role="tab">
            <?=Yii::t('app', 'Profile');?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav-1-1-dark-hor-right--2" role="tab">
            <?=Yii::t('app', 'Social Media');?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav-1-1-dark-hor-right--3" role="tab">
            <?=Yii::t('app', 'Links');?>
        </a>
    </li>
</ul>
<!-- End Nav tabs -->

<!-- Tab panes -->
<div id="nav-1-1-dark-hor-right" class="tab-content">
    <div class="tab-pane fade show active" id="nav-1-1-dark-hor-right--1" role="tabpanel">

        <div class="office-view">

            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => $this->title,
                    'type' => DetailView::TYPE_DEFAULT,
                ],
                'attributes' => [
                    [
                        'columns' => [
                            [
                                'attribute'=>'title',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'unique_id',
                                'valueColOptions'=>['style'=>'width:30%'],
                                'options' => ['prompt' => '', 'disabled' => true],
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'attribute'=>'phone_number',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'fax_number',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'attribute'=>'email',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'web',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],

                    [
                        'columns' => [
                            [
                                'attribute'=>'latitude',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'longitude',
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'attribute'=>'address',
                                'type'=>DetailView::INPUT_TEXTAREA,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'description',
                                'type'=>DetailView::INPUT_TEXTAREA,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],

                        ],
                    ],
                    [
                        'group'=>true,
                        'rowOptions'=>['class'=>'default']
                    ],
                    [
                        'columns' => [
                            [
                                'attribute'=>'created_at',
                                'format'=>'date',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'updated_at',
                                'format'=>'date',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'attribute'=>'created_by',
                                'value'=>($model->created_by!=null) ? \common\models\User::getName($model->created_by):'',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'updated_by',
                                'value'=>($model->updated_by!=null) ? \common\models\User::getName($model->updated_by):'',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],
                ],
                'deleteOptions' => [
                    'url' => ['delete', 'id' => $model->id],
                ],
                'enableEditMode' => Yii::$app->user->can('update-office'),
            ]) ?>

        </div>

    </div>

    <div class="tab-pane fade" id="nav-1-1-dark-hor-right--2" role="tabpanel">
        <?php
            echo $this->render('//office-media/index', [
                    'dataProvider' => $dataProviderSocial,
                    'mediaType' => MediaTypeHelper::getSocial(),
            ]);
        ?>
    </div>

    <div class="tab-pane fade" id="nav-1-1-dark-hor-right--3" role="tabpanel">
        <?php
            echo $this->render('//office-media/index', [
                'dataProvider' => $dataProviderLinks,
                'mediaType' => MediaTypeHelper::getLink(),
            ]);
        ?>
    </div>

</div>
<!-- End Tab panes -->
