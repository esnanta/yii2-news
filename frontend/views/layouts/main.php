<?php
/**
 * @var View   $this
 * @var string $content
 */

use common\widgets\DbText;
use yii\bootstrap4\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->beginContent('@frontend/views/layouts/base.php');
?>
<div class="container">

    <?php echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>

    <?php if (Yii::$app->session->hasFlash('alert')) { ?>
        <?php echo Alert::widget([
            'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
            'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
        ]); ?>
    <?php } ?>

    <!-- Example of your ads placing -->
    <?php echo DbText::widget([
        'key' => 'ads-example',
    ]); ?>

    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>