<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Tur;
use app\models\TurSearch;
use app\models\Category;
// Generate a bootstrap responsive striped table with row highlighted on hover

$this->title = 'Регламент турнира';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

<?php
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
                
                return Yii::$app->controller->renderPartial('_expand-row-details', [
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
        
        'name',
        'clas',
        'program',
        'skay',
        'solo',
        'agemin',
        'agemax',
        'age_id',            
        'dances',
    
    ];



    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary'=>true,
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



