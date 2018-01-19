<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'sortable-table'
        ],
       
        'columns' => [
            [
                'attribute'=>'otd_id', 
                'value'=>function ($model, $key, $index, $widget) { 
                    return 'Отделение ' . $model->category->otd->name;
                },
                'group'=>true,
                'groupedRow' => true,                
                'contentOptions' => ['class'=>'disabled'],
            ],
            [
                'attribute' => 'turTime',
            ],
            
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'nomer',
                'width' => '70px',
            ],
            [
                'attribute' => 'category.name',
                'value' => function($model){
                    return $model->category->id . '. '. $model->category->name;
                }
            ],
            
            'name',
            [
                'attribute' => 'regPairs',
                'width' => '70px',
                'value' => function ($model, $key, $index, $widget) { 
                return $model->regPairs;
				}
            ],
            [
                'attribute' => 'category.program',
                'width' => '80px',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->category->program == '1' ? 'Latina' : ($model->category->program == '2' ? 'Standart' : '10 dances') ;
                }
            ],
            [
                'attribute' => 'dances',
                'value' => function($model){
                    return $model->getDanceToString($model->dances);
                },
                'width' => '100px',
            ],
            [
                'attribute' => 'zahodcount',
                'width' => '100px',
            ],
            
            
            
            // 'ParNextTur',
            // 'typeSkating',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
