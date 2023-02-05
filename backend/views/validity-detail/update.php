<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ValidityDetail $model
 */

$this->title = 'Update Validity Detail: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Validity Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                ValidityDetail            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="validity-detail-update">
            <div class="row">
                <div class="col-md-9">
                    <?= $this->render('_form_update', [
                        'model' => $model,
                        'validityList'      => $validityList,
                        'customerList'      => $customerList,
                        'deviceStatusList'  => $deviceStatusList,
                        'billingStatusList' => $billingStatusList,                
                    ]) ?>                    
                </div>
                <div class="col-md-3">
                    <?=$this->render('/customer/side_view',[
                        'customer'=>$customer,
                        'enrolment'=>$enrolment,
                    ])
                    ?>                         
                </div>
            </div>


        </div>
        
    </div>
</div>



