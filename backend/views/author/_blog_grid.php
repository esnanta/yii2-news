<?php
use yii\helpers\Html;
use backend\models\Tag;
use common\helper\Helper;
$unset = '#NA';
?>

<?php 
    $blogCover = str_replace('frontend', 'backend', $model->getCover($model->content));
    $vid = '';
    if (strpos($blogCover, 'iframe') !== false) {
        echo $vid=$scr;
    }  
    
    $tmpAthorImage  = (empty($model->author_id)) ? $model->getDefaultAuthorImage() : $model->author->getImageUrl();
    $authorImage    = str_replace('frontend', 'backend', $tmpAthorImage);     
    
?>
   
       

<div class="post">
    <div class="user-block">
        <?= Html::img($authorImage, ['class' => 'img-circle img-bordered-sm']);?>
        <span class="username">
            <?= Html::a($model->title, $model->getUrl(),['class'=>'']); ?>
            <span class="link-black text-sm pull-right"><i class="fa fa-eye margin-r-5"></i> Views <?=$model->view_counter;?></span>
        </span>
        <span class="description"><?= (empty($model->author_id)) ? $unset: Html::a('<i class="fa fa-user"></i> '.$model->author->title, $model->author->getUrl(), ['class' => '']);?> On - <?= Yii::$app->formatter->format($model->created_at, 'date');?> - <?= Helper::getTimeElapsedString($model->created_at) ;?></span>
        
    </div>
    <!-- /.user-block -->
    <p>
        <?= strip_tags($model->readMore(400));?>
    </p>
    <ul class="list-inline">
        <li>
        <?php
            foreach(Tag::string2array($model->tags) as $tag){
                echo '<span class="label label-success">'.$tag.'</span> ';
            }
        ?>
        </li>
        <li class="pull-right">
            <?= ($model->publish_status!=null) ? $model->getOnePublishStatus($model->publish_status):'';?>
            <?= ($model->pinned_status!=null) ? $model->getOnePinnedStatus($model->pinned_status):'';?>
            
        </li>
    </ul>

</div>

<hr>