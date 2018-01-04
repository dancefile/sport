<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="in-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],         
        'toolbar' =>  [
            ['content' => 
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['in/create'], ['class' => 'btn btn-success']) 
            ],
            '{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            'tur.category.name',
            [
                'attribute' => 'couple_nomer',
                'value' => function($model){
                    return $model->nomer;
                }
            ],
            'couple.age',
            [
                'attribute' => 'dancerId1',
                'value' => function($model){
                    return $model->couple->dancerId1 ? $model->couple->dancerId1->dancerFullName : NULL;
                }
            ],
            'couple.dancerId1.classes',
            [
                'attribute' => 'dancerId2',
                'value' => function($model){
                    return $model->couple->dancerId2 ? $model->couple->dancerId2->dancerFullName : NULL;
                }
            ],
            'couple.dancerId2.classes',
            'city',
            'couple.club',
            'couple.trenersString',            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{delete}',
            ],
        ],
    ]); ?>
</div>
