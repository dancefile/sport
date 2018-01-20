<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');

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
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['registration/create'], ['class' => 'btn btn-success']) 
            ],
            '{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            [
                'attribute'=>'tur.category.name', 
                'group'=>true,
                'groupedRow' => true,
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            
            [
                'attribute' => 'couple_nomer',
                'options' => ['width' => '50'],
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
                'headerOptions' => ['width' => '60'],
                'buttons' => [
                   'update' => function ($url, $model, $key){
                      return Html::a('', ['registration/update', 'id'=>$model->id], ['class' => 'glyphicon glyphicon-pencil']);
                   },
//                   'delete' => function ($url, $model, $key){
//                      return Html::a('', ['delete'], ['class' => 'glyphicon glyphicon-cancel']);
//                   }
                ]
            ],
        ],
    ]); ?>
</div>
