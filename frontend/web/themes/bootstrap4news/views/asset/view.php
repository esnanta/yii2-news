<?php

use common\helper\IconHelper;
use common\helper\MessageHelper;
use common\helper\SpreadsheetHelper;
use common\models\Asset;
use lesha724\documentviewer\ViewerJsDocumentViewer;
use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Asset $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Asset', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$downloadLinkTmp = Html::a(IconHelper::getDownload().' Download', ['asset/download','id'=>$model->id,'title'=>$model->title],['class'=>'float-right']);
$downloadLink = str_replace('frontend', 'backend', $downloadLinkTmp);
?>
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title . $downloadLink,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            'title',
            'description:ntext',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]) ?>


    <?php
        if(!empty($model->asset_name)){
            $assetUrl       = $model->getAssetUrl();
            $currentFile    = $model->getAssetFile();
            $fileExtension  = pathinfo($currentFile, PATHINFO_EXTENSION);
            $fileData       = null;
            $fileType       = null; // Type of file: 'spreadsheet', 'image', 'document'
            $helper         = null;

            if (!empty($currentFile)) {
                try {
                    $fileExtension = pathinfo($currentFile, PATHINFO_EXTENSION);

                    // Identify file type based on extension
                    if (in_array(strtolower($fileExtension), ['xlsx', 'xls'])) {
                        // Spreadsheet handling
                        $fileType = Asset::ASSET_TYPE_SPREADSHEET;
                        $spreadsheetHelper = SpreadsheetHelper::getInstance();
                        $helper = $spreadsheetHelper->getHelper();
                        $reader = $spreadsheetHelper->getReader($currentFile);
                        $spreadsheet = $reader->load($currentFile);
                        $activeRange = $spreadsheet->getActiveSheet()->calculateWorksheetDataDimension();
                        $fileData = $spreadsheet->getActiveSheet()->rangeToArray(
                            $activeRange, null, true, true, true
                        );

                    } elseif (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                        // Image handling
                        $fileType = Asset::ASSET_TYPE_IMAGE;
                        $fileData = $currentFile; // Assuming this is the file path to display the image
                    } elseif (in_array(strtolower($fileExtension), ['pdf', 'doc', 'docx'])) {
                        // Document handling
                        $fileType = Asset::ASSET_TYPE_PDF;
                        $fileData = $currentFile; // Assuming this is the file path for download or preview
                    }
                } catch (\Exception $e) {
                    MessageHelper::getFlashAssetNotFound();
                }
            }

            if($fileType == Asset::ASSET_TYPE_IMAGE){
                echo Html::img($assetUrl, ['class' => 'img-fluid']);
            } elseif ($fileType == Asset::ASSET_TYPE_SPREADSHEET){
                $helper->displayGrid($fileData);
            } else {
                echo ViewerJsDocumentViewer::widget([
                    'url'=> str_replace('frontend','backend',$assetUrl),//url на ваш документ
                    'width'=>'100%',
                    'height'=>'300px',
                    //https://geektimes.ru/post/111647/
                ]);
            }
        }
    ?>


