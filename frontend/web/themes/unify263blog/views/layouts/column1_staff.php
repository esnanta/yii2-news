<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php'); 

?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="g-brd-around g-brd-gray-light-v4 g-pa-20 g-mb-40">
                <?= $content; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>