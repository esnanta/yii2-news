<?php

use common\helper\LabelHelper;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\AuthorMediaSearch $searchModel
 */
$route = ['staff-media/create','staff'=>$model->id,'type'=>$mediaType];
$create = LabelHelper::getCreateButton($route);
?>
<div class="author-media-index">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col"><?=Yii::t('app', 'Title');?></th>
            <th scope="col"><?=Yii::t('app', 'Description');?></th>
            <th scope="col"><?=$create;?></th>
        </tr>
        </thead>
        <tbody>

        <?php
            $models = $dataProvider->getModels();
            foreach ($models as $i=>$modelItemData) {


        ?>
                <tr>
                    <th scope="row"><?=($i+1);?></th>
                    <td><?=$modelItemData->title;?></td>
                    <td><?=$modelItemData->description;?></td>
                    <td>
                        <?php
                        $update = Html::a('<i class="fas fa-pencil-alt"></i>',
                            Yii::$app->urlManager->createUrl(['staff-media/view', 'id' => $modelItemData->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Edit'),
                                'class' => 'btn btn-sm btn-info',
                            ]
                        );

                        $view = Html::a('<i class="fas fa-eye"></i>',
                            Yii::$app->urlManager->createUrl(['staff-media/view', 'id' => $modelItemData->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Edit'),
                                'class' => 'btn btn-sm btn-info',
                            ]
                        );

                        echo $update.' '.$view;
                        ?>
                    </td>
                </tr>
        <?php } ?>

        </tbody>
    </table>

</div>
