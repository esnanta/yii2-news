<?php

use common\models\Staff;
use common\models\StaffSocialAccount;
use common\service\FileDisplayService;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var array $officeOptions
 * @var array $jobTitleOptions
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$activeTab = Yii::$app->request->get('tab', 'profile');
$socialAccounts = $model->getStaffSocialAccounts()
    ->with('platform')
    ->orderBy(['sequence' => SORT_ASC, 'id' => SORT_ASC])
    ->all();
?>
<div class="staff-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(
                Yii::t('backend', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            ); ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]); ?>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <?php echo Html::a(
                        Yii::t('backend', 'Detail'),
                        ['view', 'id' => $model->id, 'tab' => 'profile'],
                        ['class' => 'nav-link'.($activeTab !== 'social-account' ? ' active' : '')]
                    ); ?>
                </li>
                <li class="nav-item">
                    <?php echo Html::a(
                        Yii::t('backend', 'Social Accounts'),
                        ['view', 'id' => $model->id, 'tab' => 'social-account'],
                        ['class' => 'nav-link'.($activeTab === 'social-account' ? ' active' : '')]
                    ); ?>
                </li>
            </ul>

            <div class="pt-3">
                <?php if ($activeTab === 'social-account') : ?>
                    <div class="d-flex justify-content-end mb-3">
                        <?php echo Html::a(
                            Yii::t('backend', 'Add Social Account'),
                            ['staff-social-account/create', 'staff_id' => $model->id],
                            ['class' => 'btn btn-success btn-sm']
                        ); ?>
                    </div>

                    <?php if (empty($socialAccounts)) : ?>
                        <div class="text-muted"><?php echo Yii::t('backend', 'No social accounts added yet.'); ?></div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th><?php echo Yii::t('backend', 'Platform'); ?></th>
                                        <th><?php echo Yii::t('backend', 'Title'); ?></th>
                                        <th><?php echo Yii::t('backend', 'Profile Url'); ?></th>
                                        <th><?php echo Yii::t('backend', 'Primary'); ?></th>
                                        <th><?php echo Yii::t('backend', 'Visible'); ?></th>
                                        <th><?php echo Yii::t('backend', 'Sequence'); ?></th>
                                        <th class="text-right"><?php echo Yii::t('backend', 'Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($socialAccounts as $account) : ?>
                                        <?php
                                        $isPrimary = $account->is_primary === StaffSocialAccount::FLAG_YES;
                                        $isVisible = $account->is_visible === StaffSocialAccount::FLAG_YES;
                                        $platformName = $account->platform
                                            ? $account->platform->name
                                            : Yii::t('backend', 'Unknown');
                                        ?>
                                        <tr>
                                            <td><?php echo Html::encode($platformName); ?></td>
                                            <td><?php echo Html::encode($account->title ?: '-'); ?></td>
                                            <td>
                                                <?php if (!empty($account->profile_url)) : ?>
                                                    <?php echo Html::a(
                                                        Html::encode($account->profile_url),
                                                        $account->profile_url,
                                                        ['target' => '_blank', 'rel' => 'noopener']
                                                    ); ?>
                                                <?php else : ?>
                                                    <?php echo Html::encode('-'); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $isPrimary
                                                    ? 'badge-success'
                                                    : 'badge-secondary'; ?>">
                                                    <?php echo $isPrimary
                                                        ? Yii::t('backend', 'Yes')
                                                        : Yii::t('backend', 'No'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $isVisible
                                                    ? 'badge-success'
                                                    : 'badge-secondary'; ?>">
                                                    <?php echo $isVisible
                                                        ? Yii::t('backend', 'Yes')
                                                        : Yii::t('backend', 'No'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo Html::encode((string) $account->sequence); ?></td>
                                            <td class="text-right">
                                                <?php echo Html::a(
                                                    Yii::t('backend', 'Update'),
                                                    [
                                                        'staff-social-account/update',
                                                        'id' => $account->id,
                                                        'staff_id' => $model->id,
                                                    ],
                                                    ['class' => 'btn btn-primary btn-sm']
                                                ); ?>
                                                <?php echo Html::a(
                                                    Yii::t('backend', 'Delete'),
                                                    [
                                                        'staff-social-account/delete',
                                                        'id' => $account->id,
                                                        'staff_id' => $model->id,
                                                    ],
                                                    [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data' => [
                                                            'confirm' => Yii::t(
                                                                'backend',
                                                                'Are you sure you want to delete this item?'
                                                            ),
                                                            'method' => 'post',
                                                        ],
                                                    ]
                                                ); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'office_id',
                                'label' => Yii::t('backend', 'Office'),
                                'value' => static function ($model) use ($officeOptions) {
                                    return $officeOptions[$model->office_id] ?? '-';
                                },
                            ],
                            [
                                'attribute' => 'job_title_id',
                                'label' => Yii::t('backend', 'JobTitle'),
                                'value' => static function ($model) use ($jobTitleOptions) {
                                    return $jobTitleOptions[$model->job_title_id] ?? '-';
                                },
                            ],
                            [
                                'label' => Yii::t('backend', 'Photo'),
                                'format' => 'raw',
                                'value' => static fn ($model) => FileDisplayService::renderImageOrFallback(
                                    $model->title,
                                    $model->base_url,
                                    $model->path,
                                    Yii::t('backend', 'No photo')
                                ),
                            ],
                            [
                                'attribute' => 'size',
                                'value' => static fn ($model) => FileDisplayService::formatSizeInKbOrMb($model->size),
                            ],
                            'title',
                            'initial',
                            'identity_number',
                            'phone_number',
                            'email:email',
                            [
                                'attribute' => 'gender',
                                'value' => static function ($model) {
                                    return Staff::genders()[$model->gender] ?? '-';
                                },
                            ],
                            [
                                'attribute' => 'status',
                                'value' => static function ($model) {
                                    return Staff::statuses()[$model->status] ?? '-';
                                },
                            ],
                            'address:ntext',
                            'description:ntext',
                        ],
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
