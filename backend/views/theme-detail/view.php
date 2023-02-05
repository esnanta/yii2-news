<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use bajadev\ckeditor\CKEditor;

/**
 * @var yii\web\View $this
 * @var backend\models\ThemeDetail $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'ThemeDetails', 'url' => ['theme/view','id'=>$model->theme_id]];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
$editWithHtml = Html::a('<i class="fa fa-html5"></i>', ['update','id'=>$model->id,'editor'=>true], [
    'class' => 'pull-right detail-button',
    'style'=>'padding:0 5px','data-toogle'=>'tooltip','title'=>'Update with editor'
]);
$stripTagsButton = Html::a('Remove Tags', ['strip-tags','id'=>$model->id], ['class' => 'pull-right detail-button label-warning','style'=>'padding:0 5px']);

$dom = new DOMDocument();
if(!empty($model->content)){
    libxml_use_internal_errors(true);
    $dom->loadHTML($model->content);
    $xpath = new DOMXPath($dom);

    foreach ($xpath->query("//img") as $node) {
        $node->setAttribute("class", "img-responsive");
    }

    $model->content = str_replace('%09', '', $dom->saveHtml());
}

?>
<div class="theme-detail-view">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Theme Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <?php 

                        $assetUrl   = $model->getImageUrl(); 
                        $tmp        = explode('.', $model->file_name);
                        $ext        = end($tmp);

                        if($ext=='jpg'||$ext=='jpeg'||$ext=='png'||$ext=='gif'){
                            echo Html::img(str_replace('frontend', 'backend', $assetUrl), ['class' => 'img-responsive']);
                    ?>

                    <?php 

                        } else {
                            echo \lesha724\documentviewer\GoogleDocumentViewer::widget([
                                'url'=> Yii::$app->getRequest()->serverName.$assetUrl,//url на ваш документ 
                                //'url'=> 'www.hubunganinternasional.id/main/admin/uploads/archive/sA9CMQGWN_JbpSHqt2lsIrMLkc9Cxfl6.docx',//url на ваш документ 
                                'width'=>'100%',
                                'height'=>'300px',
                                //https://geektimes.ru/post/111647/
                                'embedded'=>true,
                                'a'=>\lesha724\documentviewer\GoogleDocumentViewer::A_BI //A_V = 'v', A_GT= 'gt', A_BI = 'bi'
                            ]);
                        }  
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => $this->title.$editWithHtml.$create,
                    'type' => DetailView::TYPE_INFO,
                ],
                'attributes' => [
                    [
                        'attribute'=>'theme_id',
                        'value'=>$model->theme->title,
                        'type'=>DetailView::INPUT_DROPDOWN_LIST,
                        'options' => ['id' => 'theme_id', 'prompt' => '','disabled'=>true],
                        'items' => $dataList,
                        'widgetOptions'=>[
                            'data'=>$dataList,
                        ]
                    ],          
                    'title',
                    'token',
                    [
                        'attribute'=>'content', 
                        'format'=>'html',
                        'value'=>$model->content,
                        'type'=>DetailView::INPUT_WIDGET, 
                        'widgetOptions'=>[
                            'class'=> CKEditor::className(),
                            'editorOptions' => [
                                'preset' => 'basic', // basic, standard, full
                                'inline' => false,
                            ],                      
                        ],              
                    ],
                    [
                        'attribute'=>'description',
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXTAREA,
                        'displayOnly'=>(Yii::$app->user->identity->isAdmin) ? false:true,
                    ],  
                    [
                        'attribute' => 'file_name',
                        'label' => 'Asset Url',
                        'value' => 'https://'.Yii::$app->getRequest()->serverName.$model->getImageUrl(),
                        'format' => 'raw',

                        'type'=>DetailView::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class'=> FileInput::classname(),
                            'pluginOptions'=>['previewFileType' => 'any','showUpload' => false,]
                        ],
                        //'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'label' => '',
                        'value' => (file_exists($model->getImageFile())) ? Html::a('Remove Image', ['delete-image','id'=>$model->id],['class'=>'btn-more hover-effect']):'',
                        'format' => 'html'
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
                                'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'updated_by',
                                'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                                'type'=>DetailView::INPUT_HIDDEN,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                        ],
                    ],

                ],
                'deleteOptions' => [
                    'url' => ['delete', 'id' => $model->id],
                ],
                'enableEditMode' => Yii::$app->user->can('update-theme'),
            ]) ?>
        </div>
    </div>
    
    
    


</div>
