<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-index">


<?php Pjax::begin(); ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'nomer',
            'name',
            'zahodcount',
            // 'typezahod',
            // 'dances',
            // 'ParNextTur',
            // 'typeSkating',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
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
