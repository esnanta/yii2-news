<?php

use common\models\Staff;
use yii\web\View;

/**
 * @var View  $this
 * @var Staff $model
 * @var array $officeOptions
 * @var array $jobTitleOptions
 */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Staff',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'jobTitleOptions' => $jobTitleOptions,
    ]); ?>

</div>
