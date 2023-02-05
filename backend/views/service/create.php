<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Service */

$this->title = 'Create Service';
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?= Html::encode($this->title) ?>            
            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="service-create">
            <div class="row">
                <div class="col-md-9">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'customerList'=>$customerList,
                        'staffList'=>$staffList,   
                        'serviceDetails'=>$serviceDetails,
                        'serviceTypeList'=>$serviceTypeList,
                        'billingCycleList'=>$billingCycleList,
                        'type'=>$type,
                        
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