<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'DanceFile Skating';
?>
<div class="site-index">

    <div class="jumbotron">

        <p><?= Html::a('Регистрация', ['/registration/create'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Регламент', ['/reglament'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Регистрация', ['registration/create'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Расписание', ['timetable'], ['class'=>'btn btn-lg btn-success'])?></p>
        <p><?= Html::a('Регистрация', ['registration/create'], ['class'=>'btn btn-lg btn-success'])?></p>
   
        <p><a class="btn btn-lg btn-success" href="index.php?r=judges/shaxmat">Судьи</a></p>
        <p><a class="btn btn-lg btn-success" href="index.php?r=tur/index"></a></p>
        <p><a class="btn btn-lg btn-success" href="index.php?r=print">Печать документации</a></p>
    </div>


</div>
