<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Product $model
 */

$this->title = 'Update Product: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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

        <div class="product-update">

            <?= $this->render('_form', [
                'model' => $model,
                'measureList'=>$measureList,
                'productTypeList'=>$productTypeList                
            ]) ?>

        </div>
        
    </div>
</div>



