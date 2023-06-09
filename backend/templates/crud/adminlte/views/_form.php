<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'layout' => 'horizontal',

        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'offset' => '',
                'label' => 'col-sm-2',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],    
    
    
    ]); ?>

<?php foreach ($safeAttributes as $attribute) {
    echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
} ?>
    <div class="pull-right">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
