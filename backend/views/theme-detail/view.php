<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\FileInput;
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
?>
<div class="theme-detail-view">

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
            [
                'attribute'=>'description',
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,
                'displayOnly'=>(Yii::$app->user->identity->isAdmin) ? false:true,
            ],            
            'title',
            'token',
            [
                'attribute'=>'content',
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,
            ],
//             [
//                 'attribute'=>'content',
//                 'format'=>'html',
//                 'value'=>htmlspecialchars($model->content).$stripTagsButton,
//                 'value'=>$model->content.$stripTagsButton,
//                 'type'=>DetailView::INPUT_WIDGET,
//                 'widgetOptions'=>[
//                     'class'=> CKEditor::className(),
//                     'editorOptions' => [
//                         'preset' => 'full', // basic, standard, full
//                         'inline' => false,
//                         'filebrowserBrowseUrl' => 'browse-images',
//                         'filebrowserUploadUrl' => 'upload-images',
//                         'extraPlugins' => 'imageuploader',
//                     ],
//                 ],
//             ],
            [
                'attribute' => 'image',
                'value' => ($model->getImageUrl()),
                'format' => ['image',['width'=>'auto','height'=>'100%']],

                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=>[
                    'class'=> FileInput::classname(),
                ]
            ],
            [
                'label' => '',
                'value' => (file_exists($model->getImageFile())) ? Html::a('Remove Image', ['delete-image','id'=>$model->id],['class'=>'btn-more hover-effect']):'',
                'format' => 'html'
            ],

        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-content'),
    ]) ?>

</div>
