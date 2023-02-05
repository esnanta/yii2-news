<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ValidityDetail $model
 */

$this->title = 'Create Validity Detail';
$this->params['breadcrumbs'][] = ['label' => 'Validity Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="validity-detail-create">

            <div class="row">
                <div class="col-md-9">
                    <b>Periode Sudah Dibuat</b>
                    <br></br>
                    <p>
                    <?php
                        $limit = 12;
                        foreach ($createdValidityDetails as $i=>$createdValidityDetailModel) {
                            if($i < $limit){
                                echo '<span class="label label-primary" style="margin-right:5px; font-size:13px">'.$createdValidityDetailModel->validity->title.'</span>';
                            }
                            else{
                                $limit = $limit+12;
                                echo '<p></p><span class="label label-primary" style="margin-right:5px; font-size:13px">'.$createdValidityDetailModel->validity->title.'</span>';
                            }
                        }
                    ?>            
                        </p>
                    <hr>

                    <?= $this->render('_form', [
                            'model'                     => $model,
                            'validityList'              => $validityList,
                            'customerList'              => $customerList,
                            'deviceStatusList'          => $deviceStatusList,
                            'billingStatusList'         => $billingStatusList,                   
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
        
        
        <div class="row">
            <div class="col-md-10">
               
            </div>  
            <div class="col-md-2">

           
            </div>            
        </div>
        

        
    </div>
</div>