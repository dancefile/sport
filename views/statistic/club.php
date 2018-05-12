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
            'id',
            'club:text:Клуб',
//            'city:text:Город',
            'dancer_count:text:Количество танцоров',
            'in_count:text:Количество регистраций',
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
        'panel'=>[
            'type'=>'primary',
            'heading'=>'Статистика по клубам'
        ]
                   
    ]); ?>
</div>
