<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php'); 

?>

<div class="container g-pt-50 g-pb-20">
    <div class="row justify-content-between">
        <div class="col-lg-12 g-mb-80">
            <div class="g-pr-20--lg">
                <div class="masonry-grid row g-mb-70">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endContent(); ?>