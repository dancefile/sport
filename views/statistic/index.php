<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Статистика';
?>
<div class="site-index">
    <div class="jumbotron">
        <p><?=Html::a('По городам', ['/statistic/city'], ['class'=>""])?></p>
        <p><?=Html::a('По клубам', ['/statistic/club'], ['class'=>""])?></p>
    </div>
</div>
