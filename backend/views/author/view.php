<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var backend\models\Author $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>


<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-md-6">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img src="<?= $model->getImageUrl() ?>" class="profile-user-img img-responsive img-circle" style="width:100px;height:100px" alt="<?= $model->title; ?>"/>

                <h3 class="profile-username text-center">
                    <?= Html::a($model->title, ['/author/update', 'id' => $model->id,]); ?>
                </h3>

                <p class="text-muted text-center"><?= $model->email; ?></p>


                <strong><i class="fa fa-google-plus margin-r-5"></i> Google+</strong>

                <p class="text-muted">
                    <?= $model->google_plus; ?>
                </p>

                <strong><i class="fa fa-twitter margin-r-5"></i> Twitter</strong>

                <p class="text-muted">
                    <?= $model->twitter; ?>
                </p>

                <strong><i class="fa fa-instagram margin-r-5"></i> Instagram</strong>

                <p class="text-muted">
                    <?= $model->instagram; ?>
                </p>

                <strong><i class="fa fa-book margin-r-5"></i> Deskripsi</strong>

                <p class="text-muted">
                    <?= $model->description; ?>
                </p>

                <?= Html::a('Change Avatar', ['/author/update', 'id' => $model->id, 'edit' => 't'], ['class' => 'btn btn-primary btn-block']); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>




    <div class="col-md-9">
        <div class="box box-default">


            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                <li><a href="#blogs" data-toggle="tab">Blogs</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="profile">
                        <?= DetailView::widget([
                            'model' => $model,
                            'condensed' => false,
                            'hover' => true,
                            'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                            'panel' => [
                                'heading' => $this->title,
                                'type' => DetailView::TYPE_INFO,
                            ],
                            'buttons1' => '{update}{delete}',
                            'attributes' => [
                                [
                                    'attribute'=>'title',
                                    //'valueColOptions'=>['style'=>'width:30%']
                                ],
                                [
                                    'columns' => [
                                        [
                                            'attribute'=>'phone_number',
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                        [
                                            'attribute'=>'email',
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                    ],
                                ],
                                [
                                    'columns' => [
                                        [
                                            'attribute'=>'google_plus',
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                        [
                                            'attribute'=>'instagram',
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                    ],
                                ],

                                [
                                    'columns' => [
                                        [
                                            'attribute'=>'twitter',
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                        [
                                            'attribute'=>'facebook',
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                    ],
                                ],

                                [
                                    'attribute'=>'description',
                                    'format'=>'html',
                                    'value'=>$model->description,
                                    'type'=>DetailView::INPUT_WIDGET,
                                    'widgetOptions'=>[
                                        'class'=> CKEditor::className(),
                                        'editorOptions' => [
                                            'preset' => 'basic', // basic, standard, full
                                            'inline' => false,
                    //                        'filebrowserBrowseUrl' => 'browse-images',
                    //                        'filebrowserUploadUrl' => 'upload-images',
                    //                        'extraPlugins' => 'imageuploader',
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
                                            'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                                            'type'=>DetailView::INPUT_HIDDEN,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                        [
                                            'attribute'=>'updated_by',
                                            'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                                            'type'=>DetailView::INPUT_HIDDEN,
                                            'valueColOptions'=>['style'=>'width:30%']
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
                <div class="tab-pane" id="blogs">

                    <?=
                        ListView::widget([
                            'dataProvider' => $dataProvider,
                            'summary' => '',
                    //        'options' => [
                    //             'tag' => 'div',
                    //             'class' => 'masonry-box margin-bottom-50', //Masonry Box
                    //             'id' => '',//list-wrapper
                    //         ],
                            'itemOptions' => [
                                'tag' => 'div',
                                'class' => '', //Blog Grid
                            ],

//                            'pager' => [
//                                'firstPageLabel' => 'first',
//                                'lastPageLabel' => 'last',
//                                'prevPageLabel' => '<span class="glyphicon glyphicon-chevron-left"></span>',
//                                'nextPageLabel' => '<span class="glyphicon glyphicon-chevron-right"></span>',
//                                'maxButtonCount' => 3,
//                                // Customzing options for pager container tag
//                                'options' => [
//                                    //'tag' => 'div',
//                                    'class' => 'u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14',
//                                    //'id' => 'pager-container',
//                                ],
//
//                                // Customzing CSS class for pager link
//                                'linkOptions' => ['class' => 'rounded-3x'],
//                                'activePageCssClass' => 'active',
//                                'disabledPageCssClass' => 'disabled',
//
//                                // Customzing CSS class for navigating link
//                                'prevPageCssClass' => 'previous',
//                                'nextPageCssClass' => 'next',
//                                'firstPageCssClass' => 'first',
//                                'lastPageCssClass' => 'last',
//                            ],

                            'itemView' => '_blog_grid',
                        ]);
                    ?>


                </div>

                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        </div>
        <!-- /.nav-tabs-custom -->
    </div>

</div>
