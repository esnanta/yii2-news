<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Billing $model
 */

$this->title = 'Create Billing';
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Billing            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="billing-create">
            <div class="row">
                <div class="col-md-9">
                    <?= $this->render('_form', [
                            'model'                 => $model,
                            'validityDetailList'    => $validityDetailList,   
                            'customerList'          => $customerList,
                            'billingTypeList'       => $billingTypeList,
                            'paymentStatusList'     => $paymentStatusList                
                    ]) 
                    ?>                    
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