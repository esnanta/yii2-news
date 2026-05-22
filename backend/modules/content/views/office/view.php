<?php

use common\models\OfficeSocialAccount;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Office $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(
                Yii::t('backend', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            ); ?>
            <?php echo Html::a(
                Yii::t('backend', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]
            ); ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'unique_id',
                    'title',
                    'phone_number',
                    'fax_number',
                    'email:email',
                    'web',
                    'address',
                    'latitude',
                    'longitude',
                    'description:ntext',
                    'created_at',
                    'updated_at',
                ],
            ]); ?>
        </div>
    </div>

    <?php $socialAccounts = $model->officeSocialAccounts; ?>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title mb-0"><?php echo Yii::t('backend', 'Office Social Accounts'); ?></h3>
            <?php echo Html::a(
                Yii::t('backend', 'Create'),
                ['office-social-account/create', 'office_id' => $model->id],
                ['class' => 'btn btn-success btn-sm']
            ); ?>
        </div>
        <div class="card-body p-0">
            <?php if (empty($socialAccounts)) : ?>
                <div class="p-3 text-muted">
                    <?php echo Yii::t('backend', 'No social accounts added yet.'); ?>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th><?php echo Yii::t('backend', 'Platform'); ?></th>
                                <th><?php echo Yii::t('backend', 'Username'); ?></th>
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
                                $isPrimary = $account->is_primary === OfficeSocialAccount::FLAG_YES;
                                $isVisible = $account->is_visible === OfficeSocialAccount::FLAG_YES;
                                $platformName = $account->platform
                                    ? $account->platform->name
                                    : Yii::t('backend', 'Unknown');
                                ?>
                                <tr>
                                    <td><?php echo Html::encode($platformName); ?></td>
                                    <td><?php echo Html::encode($account->username ?: '-'); ?></td>
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
                                        <span class="badge <?php echo $isPrimary ? 'badge-success' : 'badge-secondary'; ?>">
                                            <?php echo $isPrimary
                                                ? Yii::t('backend', 'Yes')
                                                : Yii::t('backend', 'No'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $isVisible ? 'badge-success' : 'badge-secondary'; ?>">
                                            <?php echo $isVisible
                                                ? Yii::t('backend', 'Yes')
                                                : Yii::t('backend', 'No'); ?>
                                        </span>
                                    </td>
                                    <td><?php echo Html::encode((string)$account->sequence); ?></td>
                                    <td class="text-right">
                                        <?php echo Html::a(
                                            Yii::t('backend', 'Update'),
                                            ['office-social-account/update', 'id' => $account->id],
                                            ['class' => 'btn btn-primary btn-sm']
                                        ); ?>
                                        <?php echo Html::a(
                                            Yii::t('backend', 'Delete'),
                                            ['office-social-account/delete', 'id' => $account->id],
                                            [
                                                'class' => 'btn btn-danger btn-sm',
                                                'data' => [
                                                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
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
        </div>
    </div>
</div>
