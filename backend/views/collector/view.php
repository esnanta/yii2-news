<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\Select2;

use kartik\grid\GridView;
use yii\widgets\Pjax;

use dosamigos\chartjs\ChartJs;
/**
 * @var yii\web\View $this
 * @var backend\models\Collector $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Collectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create     = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
$currYear   = date('Y',time());
?>
<div class="collector-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create,
            'type' => DetailView::TYPE_PRIMARY,
        ],
        'attributes' => [
            [
                'columns' => [
                    [
                        'attribute'=>'area_id', 
                        'value'=>($model->area_id!=null) ? $model->area->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'area_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $areaList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$areaList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],             

                    [
                        'attribute'=>'staff_id', 
                        'value'=>($model->staff_id!=null) ? $model->staff->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'staff_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $staffList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$staffList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                    
                                                  
                ],
            ],            
                 
            
            [
                'columns' => [
                    [
                        'attribute'=>'title',
                        'type'=>DetailView::INPUT_TEXT,  
                        'valueColOptions'=>['style'=>'width:30%']
                    ],  
                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXTAREA,   
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                
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
        'enableEditMode' => Yii::$app->user->can('update-collector'),
    ]) ?>

</div>

    <?=
        Html::a('<i class="glyphicon glyphicon-list"></i> ' . 'Update Billing Area',
            ['/collector/update-billing','id'=>$model->id],
            [
                'class' => 'btn btn-primary',
                'data-toggle' => 'tooltip',
                'title' => 'Update Billing Area' 
            ]
        );
    ?>
<div class="row">
    <div class="col-md-8">
        <p class="text-center">
            <strong>Tahun <?=$currYear;?></strong>
        </p>
        <div class="chart">
            <?= 
                ChartJs::widget([
                    'type' => 'line',
                    'data' => [
                        'labels' => [
                                        'januari','februari','maret',
                                        'april','mei','juni',
                                        'juli','agustus','september',
                                        'oktober','november', 'desember',
                                    ],
                        'datasets' => [
                            [
                                'label' => "Grafik Lunas",
                                'backgroundColor' => "rgba(0, 0, 255,0.2)",
                                'borderColor' => "rgba(0, 0, 255,1)",
                                'pointBackgroundColor' => "rgba(0, 0, 255,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(0, 0, 255,1)",
                                'data' => $datasetPaid
                            ],
                            [
                                'label' => "Grafik Hutang",
                                'backgroundColor' => "rgba(255, 0, 0, 0.2)",
                                'borderColor' => "rgba(255, 0, 0, 1)",
                                'pointBackgroundColor' => "rgba(255, 0, 0, 1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255, 0, 0, 1)",
                                'data' => $datasetCredit
                            ],                    
                        ]
                    ]
                ]);
            ?>
        </div>
                    
    </div>
    <div class="col-md-4">
<!--        <p class="text-center">
            <strong>Detail Tagihan</strong>
        </p>        -->
        <table class="table table-condensed">
            <tbody>
                <?php
                    for($i=1;$i<=12;$i++){
                ?>
                        <tr>
                            <td>
                                <?php echo DateTime::createFromFormat('!m', $i)->format('F'); // JAN ?>                            
                            </td>
                            <td><span class="label label-primary"><?= $datasetPaid[($i-1)];?></span></td>
                            <td><span class="label label-danger"><?= $datasetCredit[($i-1)];?></span></td>
                        </tr>                
                <?php
                    }
                ?>        
            </tbody>
        </table>
    </div>
</div>
    