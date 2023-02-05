<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Outlet */

$this->title = 'Create Outlet';
$this->params['breadcrumbs'][] = ['label' => 'Outlet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?= Html::encode($this->title) ?>            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="outlet-create">            
            
            <?= $this->render('_form', [
                'model'             => $model,     
                'checkEnrolment'    => $checkEnrolment,
                'nextNumber'        => $nextNumber,
                'customerList'      => $customerList,
                'staffList'         => $staffList,
                'networkTitleList'  => $networkTitleList,
                'billingStatusList' => $billingStatusList,
                'assemblyTypeList'  => $assemblyTypeList,
                'enrolmentTypeList' => $enrolmentTypeList,
                'outletDetails'     => $outletDetails,
                'billingCycleList'  => $billingCycleList
            ]) ?>

        </div>
        
    </div>
</div>
