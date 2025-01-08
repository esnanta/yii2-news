<?php

use common\helper\IconHelper;
use common\helper\MessageHelper;
use common\helper\SpreadsheetHelper;
use common\models\Asset;
use lesha724\documentviewer\ViewerJsDocumentViewer;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\Asset $model
 */

$currentFile    = $model->getAssetFile();
$currentName    = $model->asset_name;
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
            $sheetName = $spreadsheetHelper->getSheetName();
            $reader = $spreadsheetHelper->getReader($currentFile, $sheetName);
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
            $fileType = Asset::ASSET_TYPE_DOCUMENT;
            $fileData = $currentFile; // Assuming this is the file path for download or preview
        }
    } catch (\Exception $e) {
        MessageHelper::getFlashAssetNotFound();
    }
}

?>

<div class="card border-default mb-3">
    <div class="card-header">

        <?= $model->title; ?>

        <span class="float-right">
            <?= IconHelper::getDownload();?>
            <?= (empty($model->download_counter)) ? 0 : $model->download_counter; ?>
        </span>
    </div>
    <div class="card-body text-default">

        <?php
            $assetUrl   = str_replace('frontend', 'backend', $model->getAssetUrl());
            $tmp        = explode('.', $model->asset);
            $ext        = end($tmp);

            if($fileType == Asset::ASSET_TYPE_IMAGE){
                echo Html::img($assetUrl, ['class' => 'img-fluid','width'=>100]);
            } else {
                echo ViewerJsDocumentViewer::widget([
                    'url'=> $assetUrl,//url на ваш документ
                    'width'=>'100%',
                    'height'=>'300px',
                    //https://geektimes.ru/post/111647/
                ]);
            }
        ?>

        <p><?= $model->description; ?></p>

        <div class="row">
            <div class="col-md-8">
                <!-- Contact Info -->
                <ul class="list-unstyled d-flex">
                    <li class="mr-4 d-flex align-items-center">
                        <i class="fa fa-calendar mr-2"></i>
                        <?= Yii::$app->formatter->format($model->created_at, 'date'); ?>
                    </li>
                    <li class="d-flex align-items-center">
                        <?= $model->getOneAssetType($model->asset_type) ?>
                    </li>
                </ul>
                <!-- End Contact Info -->
            </div>
            <div class="col-md-4 text-right">
                <?=
                Html::a('Download',
                    ['asset/download', 'id' => $model->id, 'title' => $model->title],
                    ['class' => 'btn btn-primary btn-sm']);
                ?>
            </div>
        </div>
    </div>
</div>
