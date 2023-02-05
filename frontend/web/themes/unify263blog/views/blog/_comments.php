<?php
use yii\helpers\Html;
?>


    <!-- Blog Comments v2 -->
    <div class="row blog-comments-v2" id="c<?= $model->id; ?>">
        <div class="commenter">
            <img class="rounded-x" src="assets/img/team/img1.jpg" alt="">
        </div>
        <div class="comments-itself">
            <h4>
                <?= $model->title ?>
            </h4>
            <p>
                <?= nl2br($model->content); ?>
            </p>
        </div>
    </div>
    <!-- End Blog Comments v2 -->

