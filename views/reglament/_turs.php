<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

// use app\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категория '.$searchModel->category->name. '.  Список туров.';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-index">


<?php Pjax::begin(); ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'condensed' => true,
        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],
        'hover' => true,
        'columns' => [
            [
                'class' => 'kartik\grid\ActionColumn',
                'noWrap' => true,
                'mergeHeader' => false,
                'vAlign' => GridView::ALIGN_TOP,
                'width' => '70px',
                'template' => '{heats}&nbsp;&nbsp;{scating}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                'urlCreator'=>function($action, $model, $key, $index){
                    return \yii\helpers\Url::to(['tur/'.$action,'id'=>$model->id]);
                },
                'header' => false,
                'buttons' => [
                   'heats' => function ($url, $model, $key){
                      return Html::a('', ['/heats', 'idT'=>$model->id], ['class' => 'glyphicon glyphicon-star']);
                   },
                   'scating' => function ($url, $model, $key){
                      return Html::a('', ['/scating/input', 'idT'=>$model->id], ['class' => 'glyphicon glyphicon-flag']);
                   },
                ]
            ],
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'category.name',
            'name',
            'nomer',
            'zahodcount',
            [
                'attribute' => 'dances',
                'value' => function($model){
                    return $model->getDanceToString($model->dances);
                },
            ],
            'regPairs',
            'ParNextTur',
            
            [
                'attribute' => 'typezahod',
                'width' => '80px',
                'value' => function ($model, $key, $index, $widget) { 
                    if (isset($model->typezahod)){
                        return $model->typezahodList[$model->typezahod];
                        
                    };
                }
            ],


            [
                'attribute' => 'typeSkating',
                'width' => '80px',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->category->skayList[$model->typeSkating];
                }
            ],

            'status',

             
        ],
        'toolbar' =>  [
            ['content' =>
                Html::a('<i class="btn-left glyphicon glyphicon-arrow-left"></i>', ['reglament/index', 'otd_id'=>$searchModel->category->otd_id], ['title' => 'Назад', 'class' => 'btn btn-success'])
            ],
            ['content' => 
                
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['tur/create', 'category_id'=>$searchModel->category_id, 'dances' => $searchModel->category->dances], ['title' => 'Добавить тур', 'class' => 'btn btn-success']) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
            ],
            
            '{export}',
            '{toggleData}',
        ],
    ]); ?>

<?php Pjax::end(); ?>

</div>
