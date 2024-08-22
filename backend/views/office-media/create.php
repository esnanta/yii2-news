<?php

use common\helper\MediaTypeHelper;
use common\models\OfficeMedia;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\OfficeMedia $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Office Media',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Office Media'),
    'url' => ['office/view','id'=>$model->office_id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header">
        <?=Yii::t('app', 'Please fill out the form below')?>
        <span class="pull-right">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="office-media-create">
            <?php

            if($model->media_type == MediaTypeHelper::getSocial()){
                echo $this->render('_form_social', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'mediaTypeList' => $mediaTypeList,
                    'iconList' => $iconList
                ]) ;
            } else {
                echo $this->render('_form', [
                    'model' => $model,
                    'officeList' => $officeList,
                    'mediaTypeList' => $mediaTypeList,
                    'iconList' => $iconList
                ]) ;
            }


            ?>
        </div>
    </div>
</div>