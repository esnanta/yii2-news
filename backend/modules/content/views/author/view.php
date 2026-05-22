<?php

use common\models\AuthorSocialAccount;
use common\service\FileDisplayService;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 * @var array $officeOptions
 * @var string $activeTab
 * @var common\models\AuthorSocialAccount[] $socialAccounts
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$primaryOptions = AuthorSocialAccount::primaryOptions();
$visibleOptions = AuthorSocialAccount::visibleOptions();
$badgeClassMap = [
    AuthorSocialAccount::FLAG_YES => 'badge-success',
    AuthorSocialAccount::FLAG_NO => 'badge-secondary',
];
?>
<div class="author-view">
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
                            ['author-social-account/create', 'author_id' => $model->id],
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
                                        $platformName = $account->platform
                                            ? $account->platform->title
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
                                                <span class="badge <?php echo $badgeClassMap[$account->is_primary]
                                                    ?? 'badge-secondary'; ?>">
                                                    <?php echo Html::encode(
                                                        $primaryOptions[$account->is_primary] ?? '-'
                                                    ); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $badgeClassMap[$account->is_visible]
                                                    ?? 'badge-secondary'; ?>">
                                                    <?php echo Html::encode(
                                                        $visibleOptions[$account->is_visible] ?? '-'
                                                    ); ?>
                                                </span>
                                            </td>
                                            <td><?php echo Html::encode((string) $account->sequence); ?></td>
                                            <td class="text-right">
                                                <?php echo Html::a(
                                                    Yii::t('backend', 'Update'),
                                                    [
                                                        'author-social-account/update',
                                                        'id' => $account->id,
                                                        'author_id' => $model->id,
                                                    ],
                                                    ['class' => 'btn btn-primary btn-sm']
                                                ); ?>
                                                <?php echo Html::a(
                                                    Yii::t('backend', 'Delete'),
                                                    [
                                                        'author-social-account/delete',
                                                        'id' => $account->id,
                                                        'author_id' => $model->id,
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
                            'phone_number',
                            'email:email',
                            'address:ntext',
                            'description:ntext',
                        ],
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
