<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ServiceReason $model
 */

$this->title = 'Create Service Reason';
$this->params['breadcrumbs'][] = ['label' => 'Service Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Service Reason
            </div>
        </div>
    </div>
    <div class="panel-body">

        <div class="service-type-create">

            <?= $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>

    </div>
</div>