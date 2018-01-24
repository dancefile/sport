<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Timetable */
/* @var $form yii\widgets\ActiveForm */
?>

<p>
    <?= Html::a('Загрузить записи', ['load', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Добавить строку', ['crete', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Сохранить', ['load', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
</p>

<?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'sortable-table table table-striped table-bordered'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                
            ],
            'time',
            ['class' => 'yii\grid\SerialColumn'],
            'category_name',
            'tur_name',
            'reg_pairs',
            'dances_count',
            'programm',
            'dances',
            'heats_count',
        ],
    ]);
?>