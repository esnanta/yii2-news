<?php

use common\models\Staff;
use yii\web\View;

/**
 * @var View  $this
 * @var Staff $model
 * @var array $officeOptions
 * @var array $jobTitleOptions
 */
$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Staff',
]).' '.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="staff-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'jobTitleOptions' => $jobTitleOptions,
    ]); ?>

</div>
