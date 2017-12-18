<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
// use app\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список туров';
$this->params['breadcrumbs'][] = $this->title;
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
            'typezahod',
            'dances',
            'regPairs',
            'ParNextTur',
            'typeSkating',
            'status',

             [
                'class' => 'kartik\grid\ActionColumn',
                'noWrap' => true,
                'mergeHeader' => false,
                'vAlign' => GridView::ALIGN_TOP,
                'width' => '50px',
                'template' => '{update}&nbsp;&nbsp;{delete}',
                // 'urlCreator'=>function($action, $model, $key, $index){
                //     return \yii\helpers\Url::to(['tur/'.$action,'id'=>$model->id]);
                // },
                'header' => false,
            ],
        ],
        'toolbar' =>  [
            ['content' => 
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['tur/create'], ['title' => 'Добавить тур', 'class' => 'btn btn-success']) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
            ],
            '{export}',
            '{toggleData}',
        ],
    ]); ?>

<?php Pjax::end(); ?>

</div>
