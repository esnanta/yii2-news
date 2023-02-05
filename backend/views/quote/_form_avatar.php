<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use developit\jcrop\Jcrop;
/**
 * @var yii\web\View $this
 * @var backend\models\Author $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 

    echo $form->field($model, 'file_name')->widget(Jcrop::className(), [
        'cropAreaWidth'=> '100%',
        'cropAreaHeight'=> '600px',        
        'width'=> '300',
        'height'=> '300' ,    
        'maxSize'=> 4097152,   
        'uploadUrl' => Url::toRoute('/author/avatar'),
    ])->label(false);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
        

    ActiveForm::end(); ?>

</div>
