<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CoupleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Couples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="couple-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Couple', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dancer_id_1',
            'dancer_id_2',
            'nomer',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
