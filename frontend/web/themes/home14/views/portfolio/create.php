<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Product $model
 */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Product            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="product-create">

            <?= $this->render('_form', [
                'model' => $model,
                'measureList'=>$measureList,
                'productTypeList'=>$productTypeList                
            ]) 
            ?>

        </div>
        
    </div>
</div>