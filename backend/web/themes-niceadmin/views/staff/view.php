<?php

use common\helper\LabelHelper;
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
$create = LabelHelper::getCreateButton();
?>


<div class="row">
    <div class="col-xl-4">

        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                <h2>Kevin Anderson</h2>
                <h3>Web Designer</h3>
                <div class="social-links mt-2">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-8">

        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                    </li>

                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">About</h5>
                        <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                        <h5 class="card-title">Profile Details</h5>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Full Name</div>
                            <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Company</div>
                            <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Job</div>
                            <div class="col-lg-9 col-md-8">Web Designer</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Country</div>
                            <div class="col-lg-9 col-md-8">USA</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Address</div>
                            <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Phone</div>
                            <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Email</div>
                            <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                        </div>

                    </div>

                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                        <!-- Profile Edit Form -->
                        <form>
                            <div class="row mb-3">
                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                <div class="col-md-8 col-lg-9">
                                    <img src="assets/img/profile-img.jpg" alt="Profile">
                                    <div class="pt-2">
                                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="fullName" type="text" class="form-control" id="fullName" value="Kevin Anderson">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="company" type="text" class="form-control" id="company" value="Lueilwitz, Wisoky and Leuschke">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="job" type="text" class="form-control" id="Job" value="Web Designer">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="country" type="text" class="form-control" id="Country" value="USA">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="address" type="text" class="form-control" id="Address" value="A108 Adam Street, New York, NY 535022">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="phone" type="text" class="form-control" id="Phone" value="(436) 486-3538 x29071">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="email" type="email" class="form-control" id="Email" value="k.anderson@example.com">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form><!-- End Profile Edit Form -->

                    </div>

                    <div class="tab-pane fade pt-3" id="profile-settings">

                        <!-- Settings Form -->
                        <form>

                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                        <label class="form-check-label" for="changesMade">
                                            Changes made to your account
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                        <label class="form-check-label" for="newProducts">
                                            Information on new products and services
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="proOffers">
                                        <label class="form-check-label" for="proOffers">
                                            Marketing and promo offers
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                        <label class="form-check-label" for="securityNotify">
                                            Security alerts
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form><!-- End settings Form -->

                    </div>

                    <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form>

                            <div class="row mb-3">
                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="password" type="password" class="form-control" id="currentPassword">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="newpassword" type="password" class="form-control" id="newPassword">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form><!-- End Change Password Form -->

                    </div>

                </div><!-- End Bordered Tabs -->

            </div>
        </div>

    </div>
</div>





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