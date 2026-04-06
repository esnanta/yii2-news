<?php

use rmrevin\yii\fontawesome\FAS;
use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var common\models\WidgetImage $model
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]); ?>
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <?php echo Yii::t('backend', 'Create a new image widget'); ?>
            </h3>
        </div>
        <div class="card-body">
            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->field($model, 'key')->textInput(['maxlength' => 100]); ?>

            <?php echo $form->field($model, 'title')->textInput(['maxlength' => 100]); ?>

            <?php echo $form->field($model, 'image')->widget(
                Upload::class,
                [
                    'url' => ['/file/storage/upload'],
                ]
            ); ?>

            <?php echo $form->field($model, 'link_url')->textInput(['maxlength' => 500]); ?>

            <?php echo $form->field($model, 'alt_text')->textInput(['maxlength' => 255]); ?>

            <?php echo $form->field($model, 'sequence')->textInput(); ?>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton(
                $model->isNewRecord ? FAS::icon('save').' '.Yii::t('backend', 'Create') : FAS::icon('save').' '.Yii::t('backend', 'Save Changes'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
            ); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

