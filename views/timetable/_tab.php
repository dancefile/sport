<?php

use yii\helpers\Html;
use richardfan\sortable\SortableGridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Timetable */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin(); ?>
<p>
    <?= Html::a('Загрузить записи', ['load', 'otd_id'=>$otd_id], ['class' => 'btn btn-danger']); ?>
    <?= Html::a('Добавить строку', ['create', 'otd_id'=>$otd_id, 'otd_name'=>$otd_name ], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Обновить время', ['timeupdate', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
</p>


<?= 
    SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'emptyCell'=>'-',
        'columns' => [
            'time',
            ['class' => 'yii\grid\SerialColumn'],
            'category_name',
            'tur_name',
            'reg_pairs',
            'dances_count',
            'programm',
            'dances',
            'heats_count',
            'tur_time',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&emsp;{delete}',
                
            ],
        ],
    ]);
?>
<?php Pjax::end(); ?>
