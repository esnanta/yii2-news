<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

use kartik\widgets\FileInput;



/**
 * @var yii\web\View $this
 * @var backend\models\Photo $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="photo-form">

    <?php 
    
$form = ActiveForm::begin([
    'options'=>['enctype'=>'multipart/form-data'] // important
]);
echo $form->field($model, 'file_name');

// display the image uploaded or show a placeholder
// you can also use this code below in your `view.php` file
$title = isset($model->file_name) && !empty($model->file_name) ? $model->file_name : 'Avatar';
echo Html::img($model->getImageUrl(), [
    'class'=>'img-thumbnail', 
    'alt'=>$title, 
    'title'=>$title
]);

// your fileinput widget for single file upload
echo $form->field($model, 'image')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']
]]);

// render the submit button
echo Html::submitButton($model->isNewRecord ? 'Upload' : 'Update', [
    'class'=>$model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
);

// render a delete image button 
if (!$model->isNewRecord) { 
    echo Html::a('Delete', ['/person/delete', 'id'=>$model->id], ['class'=>'btn btn-danger']);
}

ActiveForm::end();
    ?>

</div>
