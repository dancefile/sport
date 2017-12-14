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
                
                return Yii::$app->controller->renderPartial('_category_turs', [
                    'searchModel' => $turSearchModel, 
                    'dataProvider' => $turDataProvider,
                ]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'], 
            'expandOneOnly' => true
        ],

        [
            'attribute'=>'otd', 
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) { 
                return 'Отделение ' . $model->otds->name;
            },
            'group'=>true,
            'groupedRow' => true,
        ],


        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'vAlign' => 'middle',
            'width' => '210px',

            'editableOptions' =>  function ($model, $key, $index) use ($colorPluginOptions) {
                return [
                    'header' => 'Название категории', 
                    'size' => 'md',
                    'formOptions'=>['action' => ['/category/editname']],
                ];
            }
        ],

        'clas',
        'program',
        'skay',
        'solo',
        'agemin',
        'agemax',           
        'dances',
        [
            'attribute'=>'reg_pairs', 
            'width'=>'30px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->getCatRegPairs($model->id);
            },

        ],
    
    ];



    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'striped'=>true,
        'hover'=>true,
        'pjax' => true,
        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],

        
        
        'columns' => $gridColumns,
         
        'toolbar' =>  [
            ['content' => 
                Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => Yii::t('kvgrid', 'Add Book'), 'class' => 'btn btn-success', 'onclick' => 'category/create']) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
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



