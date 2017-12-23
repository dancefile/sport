<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="in-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create In', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'tur.category.name',
            'couple.nomer',
            'couple.age',
            'couple.dancerId1.dancerFullName',
            'couple.dancerId1.clasIdSt.name',
            'couple.dancerId1.clasIdLa.name',
            'couple.dancerId2.DancerFullName',
            'couple.dancerId2.clasIdSt.name',
            'couple.dancerId2.clasIdLa.name',
            'couple.dancerId1.club0.city.name',
            'couple.club',
            'couple.trenersString',
            // добавить тренеров циклом

            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
