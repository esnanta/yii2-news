<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Enrolment $model
 */

$this->title = 'Create Enrolment';
$this->params['breadcrumbs'][] = ['label' => 'Enrolments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Number will be assigned : <span class="label label-danger"> <?= $nextNumber ?> </span>
            <div class="pull-right">
                Enrolment            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="enrolment-create">
            <div class="row">
                <div class="col-md-9">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'networkTitleList' => $networkTitleList,
                        'enrolmentTypeList'=>$enrolmentTypeList,
                        'customerList' => $customerList,
                        'billingCycleList'=>$billingCycleList
                    ]) 
                    ?>                   
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