<?php
/**
 * @var View $this
 * @var Page $model
 */

use common\models\Page;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\View;

$this->title = $model->title;
?>


<div class="row-fluid privacy">
    <h2><?php echo $model->title; ?></h2>
    <?php echo HtmlPurifier::process($model->body, [
            'HTML.SafeIframe' => true,
            'HTML.Allowed' => 'p,b,strong,i,em,ul,ol,li,a[href],br,h2,h3,h4,blockquote,img[src|alt|class],div,span',
    ]); ?>
</div>