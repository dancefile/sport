<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DancerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dancers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dancer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dancer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'sname',
            'date',
            'clas_id_st',
            // 'clas_id_la',
            // 'booknumber',
            // 'gender',
            // 'club',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
