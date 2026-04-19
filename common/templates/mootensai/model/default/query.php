<?php
/**
     * This is the template for generating the ActiveQuery class.
     */

/* @var $this yii\web\View */
/* @var $generator mootensai\enhancedgii\crud\Generator */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

$modelNamespace = trim($generator->nsModel, '\\');
$modelClass = trim($modelClassName, '\\');
$modelFullClassName = strpos($modelClass, '\\') === false ? $modelNamespace . '\\' . $modelClass : $modelClass;

$queryBaseClassName = ltrim($generator->queryBaseClass, '\\');
$queryBaseShortName = preg_replace('/^.*\\\\/', '', $queryBaseClassName);

echo "<?php\n";
?>

namespace <?= $generator->queryNs ?>;

use <?= $modelFullClassName ?>;
use <?= $queryBaseClassName ?>;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [<?= $modelClass ?>].
 *
 * @see <?= $modelClass . "\n" ?>
 */
class <?= $className ?> extends <?= $queryBaseShortName . "\n" ?>
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return <?= $modelClass ?>[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
