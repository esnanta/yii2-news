<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Validity $model
 */

$this->title = 'Create Validasi';
$this->params['breadcrumbs'][] = ['label' => 'Validities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below | Periode Bulan : <span class="label label-danger"><?= Yii::$app->params['Year-Start'].'-'.Yii::$app->params['Year-End'] ?></span>
            <div class="pull-right">
                Validity
            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="validity-create">

            <?= $this->render('_form', [
                'model' => $model,
                'monthPeriodList'=>$monthPeriodList
            ]) 
            ?>

        </div>
        
    </div>
</div>