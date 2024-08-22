<?php

use common\helper\DateHelper;
use common\helper\UIHelper;
use common\models\User;
use kartik\editors\Summernote;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\web\JqueryAsset;

/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = UIHelper::getCreateButton();
$counter = UIHelper::viewCounterIcon();
$pinned = '<span class=float-right>'.$model->setPinUrl().'</span>';
$publish = '<span class=float-right>'.$model->setPublishUrl().'</span>';
?>
<?php
$dom = new DOMDocument();
if(!empty($model->content)){
    libxml_use_internal_errors(true);
    $dom->loadHTML($model->content);
    $xpath = new DOMXPath($dom);

    foreach ($xpath->query("//img") as $node) {
        $node->setAttribute("class", "img-fluid");
    }

    $model->content = str_replace('%09', '', $dom->saveHtml());
}
?>

<div class="article-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.' '.$counter.' '.$create,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        
        'attributes' => [
  
            [
                'columns' => [
                    [
                        'attribute'=>'title', 
                        'format'=>'html',
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'author_id', 
                        'value'=>($model->author_id!=null) ? $model->author->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'author_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $authorList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$authorList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],   
                ],
            ], 
            
            [
                'columns' => [
                    [
                        'attribute'=>'article_category_id',
                        'value'=>($model->article_category_id!=null) ? $model->articleCategory->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'article_category_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $articleCategoryList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$articleCategoryList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'publish_status', 
                        'format'=>'html',
                        'value'=>($model->publish_status!=null) ?
                            $model->getOnePublishStatus($model->publish_status).$publish:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'publish_status', 'prompt' => '', 'disabled'=>false],
                        'items' => $publishList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$publishList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],  
                ],
            ],            

            
            [
                'columns' => [
                    [
                        'attribute'=>'date_issued',
                        'format'=> 'date',
                        'type'=>DetailView::INPUT_WIDGET,             
                        'widgetOptions'=>[
                            'class'=>DateControl::class,
                            'type'=> DateControl::FORMAT_DATE,
                        ],
                    ],                                  
                    [
                        'attribute'=>'pinned_status', 
                        'format'=>'html',
                        'value'=>($model->pinned_status!=null) ?
                            $model->getOnePinnedStatus($model->pinned_status).$pinned:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'pinned_status', 'prompt' => '', 'disabled'=>false],
                        'items' => $pinnedList,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data'=>$pinnedList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ], 
                ],
            ],            
               
            
            [
                'columns' => [
                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXTAREA,                    
                    ],
                    [
                        'attribute'=>'tags',
                        'value'=> $model->tags,
                        'type'=>DetailView::INPUT_SELECT2,
                        'widgetOptions'=>[
                            'class'=> Select2::class,
                            'data' => $tagList,
                            'maintainOrder' => true,
                            'options' => [
                                'multiple' => true,
                                'value' => $tagList,
                            ],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',',' '],
                                'maximumInputLength' => 5,
                            ],
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                ],
            ],              
            
            'cover',

            [
                'group'=>true,
                'rowOptions'=>['class'=>'default']
            ],               
            [
                'attribute'=>'content', 
                'format'=>'raw',
                'value'=>$model->content,
                'type'=>DetailView::INPUT_WIDGET, 
                'widgetOptions'=>[
                    'class'=> Summernote::class
                ],              
            ], 

            [
                'group'=>true,
                'rowOptions'=>['class'=>'default']
            ],                        
            [
                'columns' => [
                    [
                        'attribute'=>'created_at', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_HIDDEN,      
                        'valueColOptions'=>['style'=>'width:30%']
                    ],  
                    [
                        'attribute'=>'updated_at', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_HIDDEN, 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'created_by',
                        'value'=>($model->created_by!=null) ? User::getName($model->created_by):'',
                        'type'=>DetailView::INPUT_HIDDEN,
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute'=>'updated_by',
                        'value'=>($model->updated_by!=null) ? User::getName($model->updated_by):'',
                        'type'=>DetailView::INPUT_HIDDEN,
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                
                ],
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-article'),
    ])?>

</div>
