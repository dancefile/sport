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
<h1 id="caption">Расписание отделения <?= $otd_name ?></h1>

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
    <button class = 'btn btn-success' type="submit" name="zahod">Печать заходов</button>
    <button class = 'btn btn-success' type="submit" name="begun">Печать бегунков</button>
    <button class = 'btn btn-success' type="submit" name="newheat">Распределить заходы</button>

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
            [
                'attribute'=>'category_name',
//                'options' => [
//                    'width' => '260px',
//                ],
            ],
            [
                'attribute'=>'tur_name',
                'options' => [
                    'width' => '100px',
                ],
            ],        
            [
                'attribute'=>'reg_pairs',
                'options' => [
                    'width' => '60px',
                ],
            ],        
            [
                'attribute'=>'dances_count',
                'options' => [
                    'width' => '60px',
                ],
            ],        
            [
                'attribute'=>'programm',
                'options' => [
                    'width' => '60px',
                ],
            ],        
            
            [
                'attribute' => 'dances',
                'value' => function ($model, $key, $index, $widget) { 
                    return \app\models\Category::getDanceToString($model->dances);
                }
            ],
            
            
            [
                'attribute'=>'heats_count',
                'options' => [
                    'width' => '60px',
                ],
            ],
            [
                'attribute'=>'tur_time',
                'options' => [
                    'width' => '60px',
                ],
            ],
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


