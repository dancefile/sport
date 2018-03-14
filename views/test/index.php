<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chesses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chess-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Chess', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'judge_id',
            'category_id',
            'nomer',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
