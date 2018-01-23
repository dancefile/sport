<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Timetable */
/* @var $form yii\widgets\ActiveForm */
?>

    <p>
        <?= Html::a('Create Timetable', ['load', 'otd_id'=>$otd_id], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterModel' => ['otd_id' == $otd_id],
       
        'columns' => [
            'otd_id',
            'time',
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'tur_number',
            'category_name',
//            'tur_id',
            'tur_name',
            'reg_pairs',
            'dances_count',
            'programm',
            'dances',
            'heats_count',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
