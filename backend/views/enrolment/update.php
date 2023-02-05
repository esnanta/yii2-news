<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Enrolment $model
 */

$this->title = 'Update Enrolment: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Enrolments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Enrolment
            </div>
        </div>
    </div>
    <div class="panel-body">

        <div class="enrolment-update">
            <div class="row">
                <div class="col-md-9">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'networkTitleList' => $networkTitleList,
                        'customerList' => $customerList,
                        'billingCycleList'=>$billingCycleList,
                        'enrolmentTypeList'=>$enrolmentTypeList,
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?=$this->render('/customer/side_view',[
                        'customer'=>$customer,
                        'enrolment'=>$model,
                    ])
                    ?>
                </div>
            </div>


        </div>

    </div>
</div>



