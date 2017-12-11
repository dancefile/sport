<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
    ]); ?>

<?php Pjax::end(); ?>

</div>
