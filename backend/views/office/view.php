<?php

use common\helper\MediaTypeHelper;
use common\models\User;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Office $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                data-bs-target="#profile" type="button" role="tab" aria-controls="home"
                aria-selected="true"><?=Yii::t('app', 'Office');?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                data-bs-target="#media-social" type="button" role="tab" aria-controls="profile"
                aria-selected="false"><?=Yii::t('app', 'Social Media');?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                data-bs-target="#media-link" type="button" role="tab" aria-controls="contact"
                aria-selected="false"><?=Yii::t('app', 'Links');?></button>
    </li>
</ul>

<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">
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
                            'value'=>($model->created_by!=null) ? User::getName($model->created_by):'',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'updated_by',
                            'value'=>($model->updated_by!=null) ? User::getName($model->updated_by):'',
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
    <div class="tab-pane fade" id="media-social" role="tabpanel" aria-labelledby="profile-tab">
        <?php
        echo $this->render('//office-media/index', [
            'dataProvider' => $dataProviderSocial,
            'mediaType' => MediaTypeHelper::getSocial(),
        ]);
        ?>
    </div>
    <div class="tab-pane fade" id="media-link" role="tabpanel" aria-labelledby="contact-tab">
        <?php
        echo $this->render('//office-media/index', [
            'dataProvider' => $dataProviderLinks,
            'mediaType' => MediaTypeHelper::getLink(),
        ]);
        ?>
    </div>
</div>