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


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <?= "<?= " ?>Html::encode($this->title) ?>
            <div class="pull-right">
                <?= "<?= " ?>Html::a(<?= $generator->generateString('Index', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>, ['index'], ['class' => 'btn btn-sm btn-primary']) ?>
            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

            <?= "<?= " ?>$this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>