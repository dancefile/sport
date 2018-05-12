<?php

use kartik\grid\GridView;

$this->title = 'Статистика';

?>

<div class="stat-index">        
    <?php
        $columns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '50'],
            ],
            'city:text:Город',
            'count:text:Количество пар',
        ];
   
    ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'autoXlFormat'=>true,
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        'emptyCell' => '-',
        'columns' => $columns,
        'pjax'=>true,
//        'showPageSummary'=>true,
        'panel'=>[
            'type'=>'primary',
            'heading'=>'Статистика по клубам'
        ],
        
                   
    ]); ?>
</div>
