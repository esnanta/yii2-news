<?php
use yii\widgets\ListView;
$this->title = 'F I R S T 2 0 1 8';
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'options' => [
            'tag' => 'ul',
            'class' => 'timeline-v1', 
            'style'=>'display:inline-block',
            'id' => '',
         ],        
        
        'itemOptions' => [
            'tag' => 'li',
            'class' => 'timeline-inverted', 
            'id' => '',
        ],      
        
        'pager' => [
            'firstPageLabel' => 'first',
            'lastPageLabel' => 'last',
            'prevPageLabel' => '<span class="glyphicon glyphicon-chevron-left"></span>',
            'nextPageLabel' => '<span class="glyphicon glyphicon-chevron-right"></span>',
            'maxButtonCount' => 3,
            // Customzing options for pager container tag
            'options' => [
                'tag' => 'ul',
                'class' => 'pager pager-v4 margin-bottom-50',
                'style' => 'float:right',
                //'id' => 'pager-container',
            ],
            
            // Customzing CSS class for pager link
            'linkOptions' => ['class' => 'rounded-3x'],
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
            
            // Customzing CSS class for navigating link
            'prevPageCssClass' => 'previous',
            'nextPageCssClass' => 'next',
            'firstPageCssClass' => 'first',
            'lastPageCssClass' => 'last',
        ],
        
        'itemView' => '_timeline_grid',
    ]);
?>     



<script>
    var all = document.getElementsByClassName('timeline-inverted');
    for (var i = 0; i < all.length; i++) {

        var index = (i+1)%2;
        var removedClass = '';

        //all[i].className = '';
        all[i].classList.remove("timeline-inverted");
    }

</script>	
    