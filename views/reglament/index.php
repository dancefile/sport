<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Tur;
use app\models\TurSearch;
use app\models\Category;



$this->title = 'Регламент турнира';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

<?php
    $colorPluginOptions =  [
        'showPalette' => true,
        'showPaletteOnly' => true,
        'showSelectionPalette' => true,
        'showAlpha' => false,
        'allowEmpty' => false,
        'preferredFormat' => 'name',
        'palette' => [
            [
                "white", "black", "grey", "silver", "gold", "brown", 
            ],
            [
                "red", "orange", "yellow", "indigo", "maroon", "pink"
            ],
            [
                "blue", "green", "violet", "cyan", "magenta", "purple", 
            ],
        ]
    ];
    $gridColumns = [
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                $turSearchModel = new TurSearch();
                $turSearchModel->category_id = $model->id;
                $turDataProvider = $turSearchModel->search(Yii::$app->request->queryParams); 
                
                return Yii::$app->controller->renderPartial('_turs', [
                    'searchModel' => $turSearchModel, 
                    'dataProvider' => $turDataProvider,
                ]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'], 
            'expandOneOnly' => true
        ],

        [
            'attribute'=>'otd_id', 
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) { 
                return 'Отделение ' . $model->otd->name;
            },
            'group'=>true,
            'groupedRow' => true,
        ],

        'name',

        [
            'attribute' => 'clas',
            'width' => '50px',
        ],
        [
            'attribute' => 'program',
            'width' => '80px',
            'value' => function ($model, $key, $index, $widget) { 
                return $model->program == '1' ? 'Latina' : ($model->program == '2' ? 'Standart' : '10 dances') ;
            }
        ],
        [
            'attribute' => 'skay',
            'width' => '80px',
            'value' => function ($model, $key, $index, $widget) { 
                return $model->skay == '1' ? 'Баллы' : ($model->skay == '2' ? 'Кресты' : 'Скейтинг') ;
            }
        ],
        [
            'attribute' => 'solo', 
            'width' => '80px',
            'value' => function ($model, $key, $index, $widget) { 
                return $model->solo == '1' ? 'Пары' : 'Соло' ;
            }

        ],        
        [
            'attribute' => 'agemin',
            'width' => '50px',
        ],

        [
            'attribute' => 'agemax',
            'width' => '50px',
        ],
        [
            'attribute' => 'dances',
            'value' => function($model){
                return $model->getDanceToString($model->dances);
            },
            'width' => '100px',
        ],
        [
            'attribute'=>'reg_pairs', 
            'width'=>'50px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->getCatRegPairs($model->id);
            },

        ],

        [
            'attribute'=>'judges_count', 
            'width'=>'50px',
            'value'=>function ($model, $key, $index, $widget) {
                return count($model->chesses);
            }

        ],

        [
            'class' => 'kartik\grid\ActionColumn',
            'noWrap' => true,
            'mergeHeader' => false,
            'vAlign' => GridView::ALIGN_TOP,
            'width' => '50px',
            'template' => '{update}&nbsp;&nbsp;{delete}',
            'urlCreator'=>function($action, $model, $key, $index){
                return \yii\helpers\Url::to(['category/'.$action,'id'=>$model->id]);
            },
            'header' => false,
        ],

    
    ];



    echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pjax' => true,
        'condensed' => true,
        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],
        
        'columns' => $gridColumns,
         
        'toolbar' =>  [
            ['content' => 
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['category/create'], ['class' => 'btn btn-default']) 
            ],
            '{export}',
            '{toggleData}',
        ],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        
    ]);

?>



