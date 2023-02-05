<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($providerPhoto->totalCount) {
    $modelPhotos    = $providerPhoto->getModels();  
    foreach ($modelPhotos as $model) {
        
    
?>


        <div class="col-sm-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h5 class="box-title">Image</h5>
                    <div class="pull pull-right">   
                        <?=    
                            Html::a('<i class="glyphicon glyphicon-heart"></i>', 
                                ['album/set-cover','id'=>$model->id,'title'=>$model->title],
                                [
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Set album cover'
                                ]
                            );
                        ?>                                     
                        <?=             
                            Html::a('<i class="glyphicon glyphicon-pencil"></i> ', 
                                ['photo/update','id'=>$model->id,'title'=>$model->title],
                                [
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Edit Photo'
                                ]
                            );
                        ?> 
                        <?=             
                            Html::a('<i class="glyphicon glyphicon-trash"></i> ', 
                                ['photo/delete','id'=>$model->id],
                                [
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Delete Photo',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this image?',
                                        'method' => 'post',
                                    ],                                                
                                ]
                            );
                        ?>                                     
                    </div>                   
                    
                </div>
                <div class="box-body">
                    <?php 
                        $img = Html::img($model->getImageUrl(), [
                            'class' => 'img-responsive',
                            //'style' => 'width:140px;height:100px'
                        ]);
                    ?>

                    <?= Html::a($img, $model->getUrl()) ?>      
                    
                    <table class="table table-hover">
                        <tr>
                            <td><?= $model->title ?>Operation</td>
                        </tr>
                        <tr>
                            <td><?= $model->description;?></td>
                        </tr>                        
                    </table>
                    
                    
                </div>
            </div>
         
            
            
        </div>




<?php 
    }
} 
?>

     