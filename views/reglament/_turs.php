<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

// use app\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Список туров';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-index">


<?php Pjax::begin(); ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'condensed' => true,
        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'category.name',
            'name',
            'nomer',
            'zahodcount',
            
            'dances',
            'regPairs',
            'ParNextTur',
            
            [
                'attribute' => 'typezahod',
                'width' => '80px',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->typezahod == '1' ? 'Постоянный' : ($model->typezahod == '2' ? 'Переменный' : 'Чередование') ;
                }
            ],


            [
                'attribute' => 'typeSkating',
                'width' => '80px',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->typeSkating == '1' ? 'Баллы' : ($model->typeSkating == '2' ? 'Кресты' : 'Скейтинг') ;
                }
            ],

            'status',

             [
                'class' => 'kartik\grid\ActionColumn',
                'noWrap' => true,
                'mergeHeader' => false,
                'vAlign' => GridView::ALIGN_TOP,
                'width' => '50px',
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'urlCreator'=>function($action, $model, $key, $index){
                    return \yii\helpers\Url::to(['tur/'.$action,'id'=>$model->id]);
                },
                'header' => false,
            ],
        ],
        'toolbar' =>  [
            ['content' => 
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['tur/create','category_id'=>$searchModel->category_id], ['title' => 'Добавить тур', 'class' => 'btn btn-success']) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
            ],
            '{export}',
            '{toggleData}',
        ],
    ]); ?>

<?php Pjax::end(); ?>

</div>
