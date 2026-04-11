<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$buildGridColumn = static function (string $name, string $format = 'text'): string {
    $normalized = strtolower($name);
    $isIdColumn = $normalized === 'id';
    $isForeignKey = substr($normalized, -3) === '_id';
    $isDateColumn = strpos($normalized, '_at') !== false || strpos($normalized, 'date') !== false;
    $isWrapColumn = preg_match('/(title|name|description|username|url|slug|address)/', $normalized) === 1
        || in_array($format, ['ntext', 'text', 'url'], true);

    $width = null;
    if ($isIdColumn) {
        $width = 8;
    } elseif ($isForeignKey) {
        $width = 12;
    } elseif ($isDateColumn) {
        $width = 12;
    } elseif (in_array($normalized, ['status', 'sequence', 'is_active', 'is_visible', 'is_primary'], true)) {
        $width = 10;
    } elseif ($isWrapColumn) {
        $width = 25;
    }

    $contentStyle = ($isDateColumn || $isIdColumn || $isForeignKey) && !$isWrapColumn
        ? 'white-space: nowrap;'
        : 'white-space: normal; word-break: break-word;';

    $result = "[\n";
    $result .= "    'attribute' => '{$name}',\n";

    if ($format !== 'text') {
        $result .= "    'format' => '{$format}',\n";
    }

    if ($width !== null) {
        $result .= "    'options' => ['style' => 'width: {$width}%'],\n";
    }

    $result .= "    'contentOptions' => ['style' => '{$contentStyle}'],\n";
    $result .= '],';

    return $result;
};

echo "<?php\n";
?>

use yii\helpers\Html;
use rmrevin\yii\fontawesome\FAS;
use <?php echo $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/**
 * @var yii\web\View $this
<?php echo !empty($generator->searchModelClass) ? " * @var " . $generator->searchModelClass . " \$searchModel\n" : '' ?>
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = <?php echo $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?php echo Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="card">
        <div class="card-header">
            <?php echo "<?php echo " ?>Html::a(FAS::icon('user-plus').' '.<?php echo $generator->generateString('Add New {modelClass}', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>, ['create'], ['class' => 'btn btn-success']); ?>
        </div>

        <div class="card-body <?php echo $generator->indexWidgetType === 'grid'? 'p-0': '' ?>">
    <?php if (!empty($generator->searchModelClass)) : ?>
        <?php echo "<?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php endif; ?>

    <?php if ($generator->indexWidgetType === 'grid') : ?>
        <?php echo "<?php echo " ?>GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'table-striped', 'table-bordered', 'mb-0', 'table-sm'],
                    'style' => 'width: 100%; table-layout: fixed;',
                ],
                'dataProvider' => $dataProvider,
                <?php echo !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n                'columns' => [\n" : "'columns' => [\n"; ?>
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'options' => ['style' => 'width: 5%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],

                    <?php
                    $count = 0;
                    if (($tableSchema = $generator->getTableSchema()) === false) {
                        foreach ($generator->getColumnNames() as $name) {
                            if (++$count < 6) {
                                echo $buildGridColumn($name) . "\n                    ";
                            } else {
                                echo "// '" . $name . "',\n";
                            }
                        }
                    } else {
                        foreach ($tableSchema->columns as $column) {
                            $format = $generator->generateColumnFormat($column);
                            if (++$count < 6) {
                                echo $buildGridColumn($column->name, $format) . "\n                    ";
                            } else {
                                echo "// '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n                    ";
                            }
                        }
                    }
        ?>

                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'options' => ['style' => 'width: 5%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                ],
            ]); ?>
    <?php else: ?>
        <?php echo "<?php echo " ?>ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return Html::a(Html::encode($model-><?php echo $nameAttribute ?>), ['view', <?php echo $urlParams ?>]);
                },
            ]) ?>
    <?php endif; ?>

        </div>
        <div class="card-footer">
            <?php echo "<?php echo " ?>getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
