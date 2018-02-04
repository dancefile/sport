<?php

use yii\helpers\Html;
use richardfan\sortable\SortableGridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Category;


//$this->registerCssFile("@web/css/print.css", [
//    'depends' => ['app\assets\AppAsset',],
//    'media' => 'print',
//], 'css-print-theme');


/* @var $this yii\web\View */
/* @var $model app\models\Timetable */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin(); ?>
<p>
    <?= Html::a('Загрузить записи', ['load', 'otd_id'=>$otd_id], ['class' => 'btn btn-danger']); ?>
    <?= Html::a('Добавить строку', ['create', 'otd_id'=>$otd_id, 'otd_name'=>$otd_name ], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Обновить время', ['timeupdate', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Печать', [' '], ['onclick'=>'print()','class' => 'btn btn-success']); ?>
    <?= Html::a('Удалить нулевые', ['deletezero', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
    

</p>


<?= 
    SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'emptyCell'=>'-',
        'columns' => [
            'time',
            ['class' => 'yii\grid\SerialColumn'],
//            'category.id',
            'category_name',
            'tur_name',
            'reg_pairs',
            'dances_count',
            'programm',
            [
                'attribute' => 'dances',
                'value' => function ($model, $key, $index, $widget) { 
                    return Category::getDanceToString($model->dances);
                }
            ],
            
            'heats_count',
            'tur_time',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&emsp;{delete}',
                'options' => [
                    'width' => '50px',
                ],
                'contentOptions' =>[
                    'class' => 'actionColumnCell'
                ]
            ],
        ],
    ]);
?>
<?php Pjax::end(); ?>
