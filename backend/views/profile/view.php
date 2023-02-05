<?php
use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Profile $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>




<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-md-6">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img src="<?= $model->getImageUrl() ?>" class="profile-user-img img-responsive img-circle" style="width:100px;height:100px" alt="<?= $model->name; ?>"/>

                <h3 class="profile-username text-center">
                    <?= Html::a($model->name, ['/profile/update', 'id' => $model->user_id,]); ?>
                </h3>

                <p class="text-muted text-center"><?= $model->user->email; ?></p>

                <strong><i class="fa fa-user"></i> Role</strong>

                <p class="text-muted margin-bottom-15">
                    <?php
                    foreach ($authAssignments as $authAssignmentModel) {
                        ?>
                        <span class="label label-default"><?php echo $authAssignmentModel->item_name; ?></span>
                        <?php
                    }
                    ?>
                </p>

                <strong><i class="fa fa-map-marker margin-r-5"></i> Lokasi</strong>

                <p class="text-muted">
                    <?= $model->location; ?>
                </p>

                <strong><i class="fa fa-globe margin-r-5"></i> Website</strong>

                <p class="text-muted">
                    <?= $model->website; ?>
                </p>

                <strong><i class="fa fa-book margin-r-5"></i> Bio</strong>

                <p class="text-muted">
                    <?= $model->bio; ?>
                </p>

                <?= Html::a('Change Avatar', ['/profile/update', 'id' => $model->user_id, 'edit' => 't'], ['class' => 'btn btn-primary btn-block']); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>




    <div class="col-md-9">
        <div class="box box-default">


            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    <?=
                        DetailView::widget([
                            'model' => $model,
                            'condensed' => false,
                            'hover' => true,
                            'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                            'panel' => [
                                'heading' => $this->title,
                                'type' => DetailView::TYPE_INFO,
                            ],
                            'buttons1' => '{update}',
                            'attributes' => [
//                                [
//                                    'attribute' => 'image',
//                                    'value' => ($model->getImageUrl()),
//                                    'format' => ['image',['width'=>'150','height'=>'150px']],
//
//                                    'type'=>DetailView::INPUT_WIDGET,
//                                    'widgetOptions'=>[
//                                        'class'=> FileInput::classname(),
//                                    ]
//                                ],
                                [
                                    'attribute'=>'user_id',
                                    'value'=>$model->user->username,
                                    'type'=>DetailView::INPUT_HIDDEN,
                                    'options' => ['id' => 'id', 'prompt' => ''],
                                    'items' => $dataList,
                                    'widgetOptions'=>[
                                        'data'=>$dataList,
                                    ]
                                ],
                                'name',
                                'public_email:email',
                                //'gravatar_email:email',
                                'location',
                                'website',
                                [
                                    'attribute'=>'bio',
                                    'type'=>DetailView::INPUT_TEXTAREA,
                                ],
                                [
                                    'attribute'=>'file_name',
                                    'type'=>DetailView::INPUT_HIDDEN,
                                ],
                            ],
                            'deleteOptions' => [
                                'url' => ['delete', 'id' => $model->user_id],
                            ],
                            'enableEditMode' => Yii::$app->user->can('update-profile'),
                        ])

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

