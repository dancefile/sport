<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OtdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Otds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="otd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Otd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'startTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
