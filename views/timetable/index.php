<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimetableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timetables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timetable-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php 
        $otds = app\models\Otd::find()->all();
        foreach ($otds as $otd) {
            $tabs[]=[
                        'label'     =>  'Отделение '.$otd['name'],
                        'content'   =>  $this->render(
                                '_form', 
                                [
                                    'dataProvider' => $dataProvider, 
                                    'filterModel' => $searchModel,
                                    'otd_id'=>$otd['id'],
                                ]),
                    ];
        }
    ?>

    <?= Tabs::widget([
            'items' => $tabs,
        ]);
    ?>
    
</div>
