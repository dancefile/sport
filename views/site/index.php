<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'DanceFile Skating';
?>
<div class="site-index">

    <div class="jumbotron">

        <p><?= Html::a('Регистрация', ['/registration/create'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Регламент', ['/reglament'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Судьи', ['/judges/shaxmat'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Расписание', ['/timetable'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Печать документации', ['/print'], ['class'=>'btn btn-lg btn-success'])?></p>
   
    </div>


</div>
