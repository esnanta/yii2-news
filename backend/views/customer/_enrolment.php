<?php
    use yii\helpers\Html;
    use kartik\detail\DetailView;

    $update = (!empty($enrolment->id)) ? Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['/enrolment/update','id'=>$enrolment->id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']) : '';

?>

<?php
    $formatter = \Yii::$app->formatter;
    if (!empty($enrolment)) {
        echo DetailView::widget([
            'model' => $enrolment,
            'condensed' => false,
            'hover' => true,
            'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel' => [
                'heading' => 'Enrolment'.$update,
                'type' => DetailView::TYPE_INFO,
            ],
            'attributes' => [
                [
                    'columns' => [
                        [
                            'attribute' => 'title',
                            'value' => ($enrolment->title != null) ? Html::a($enrolment->title, $enrolment->getUrl()) : '',
                            'format' => 'html',
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute' => 'network_id',
                            'value' => ($enrolment->network_id != null) ? Html::a($enrolment->network->title, $enrolment->network->getUrl()) : '',
                            'format' => 'html',
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'date_effective',
                            'format'=>'date',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute' => 'billing_cycle',
                            'value' => ($enrolment->billing_cycle != null) ? $enrolment->billing_cycle.' / bulan' : '',
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label' => 'Aktif',
                            'format' => 'html',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'value' => $formatter->asDecimal($enrolment->countDeviceActive()).' Outlet',
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label' => 'Iuran',
                            'format' => 'html',
                            'type'=>DetailView::INPUT_HIDDEN,
                            'value' => $formatter->asDecimal($enrolment->customer->sumMonthlyBill()),
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'attribute' => 'description',
                    'type' => DetailView::INPUT_TEXTAREA,
                    'format' => 'html',
                ],
            ],
            'deleteOptions' => [
                'url' => ['delete', 'id' => $enrolment->id],
            ],
            'enableEditMode' => false,
        ]);
    }
    else{
        echo Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'Create Enrolment',
            ['/enrolment/create','id'=>$customer->id],
            [
                'class' => 'btn btn-primary',
                'data-toggle' => 'tooltip',
                'title' => 'Create Enrolment'
            ]
        );
    }

?>