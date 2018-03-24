<?php

use yii\helpers\Html;
use richardfan\sortable\SortableGridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Category;
use yii\widgets\ActiveForm;



//$this->registerCssFile("@web/css/print.css", [
//    'depends' => ['app\assets\AppAsset',],
//    'media' => 'print',
//], 'css-print-theme');


/* @var $this yii\web\View */
/* @var $model app\models\Timetable */
/* @var $form yii\widgets\ActiveForm */
?>


<?php 
    $form = ActiveForm::begin();
    Pjax::begin(); 
?>

<p>
    <?= Html::a('Загрузить записи', ['load', 'otd_id'=>$otd_id], ['class' => 'btn btn-danger']); ?>
    <?= Html::a('Добавить строку', ['create', 'otd_id'=>$otd_id, 'otd_name'=>$otd_name ], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Обновить время', ['timeupdate', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Печать', [' '], ['onclick'=>'print()','class' => 'btn btn-success']); ?>
    <?= Html::a('Удалить нулевые', ['deletezero', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']); ?>
    <button type="submit" name="zahod">Печать заходов</button>
    <button type="submit" name="begun">Печать бегунков</button>
    <button type="submit" name="newheat">Распределить заходы</button>

</p>


<?= 
    SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'emptyCell'=>'-',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model->tur_id];
                        }
            ],
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
                    return \app\models\Category::getDanceToString($model->dances);
                }
            ],
            
            'heats_count',
            'tur_time',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&emsp;{delete}',
                'options' => [
                    'width' => '60px',
                ],
                'buttons' => [
                   'update' => function ($url, $model, $key){
                      return Html::a('', 
                              ['update', 
                                  'id'=>$model->id], ['class' => 'glyphicon glyphicon-pencil']);
                   },
                   'delete' => function ($url, $model, $key){
                      return Html::a('', 
                              ['delete', 
                                  'id'=>$model->id], ['class' => 'glyphicon glyphicon-trash', 
                                      'data'=>['method' => 'post']]);
                   }
                ]
            ],
        ],
    ]);
?>
<?php 
    Pjax::end();
    ActiveForm::end();
?>


