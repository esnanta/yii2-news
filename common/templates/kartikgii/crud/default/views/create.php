<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */

$this->title = <?= $generator->generateString('Create {modelClass}', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header">Please fill out the form below 
        <span class="pull-right">
            <?php echo StringHelper::basename($generator->modelClass) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
            <?= "<?= " ?>$this->render('_form', [
                'model' => $model,
                'officeList' => $officeList,
            ]) 
            ?>
        </div>
    </div>
</div>