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
        'filterModel' => $searchModel,
        
        'columns' => [
            'tur.category.name',
            [
                'attribute' => 'couple_nomer',
                'value' => function($model){
                    return $model->couple->nomer;
                }
            ],
            'couple.age',
            [
                'attribute' => 'dancerId1',
                'value' => function($model){
                    return $model->couple->dancerId1->dancerFullName;
                }
            ],
            'couple.dancerId1.classes',
            [
                'attribute' => 'dancerId2',
                'value' => function($model){
                    return $model->couple->dancerId2->dancerFullName;
                }
            ],
            'couple.dancerId2.classes',
            'couple.dancerId1.club0.city.name',
            'couple.club',
            'couple.trenersString',            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{delete}',
            ],
        ],
    ]); ?>
</div>
