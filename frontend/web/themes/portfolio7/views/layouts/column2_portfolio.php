<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php'); 
use yii\helpers\Html;
?>

<?=
    common\widgets\home14\Breadcrumbs::widget([
        'indexTitle' => Html::a('Index', ['portfolio/index'], ['class' => 'u-link-v5 g-color-white g-color-primary--hover']),
        'pageTitle' => 'Portfolio',
    ]); 
?> 
                
<div class="container content-md" style="padding-top:20px">
    <div class="row blog-page blog-item">
        <div class="col-md-12">
            <?= $content; ?>       
        </div>
    </div>     
</div>
    


<?php $this->endContent(); ?>