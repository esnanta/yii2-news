<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php'); 

?>
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sn-container">
                        <div class="sn-content">
                            <?= $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>