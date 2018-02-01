<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PreRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предварительная регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-registration-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{reg}',
                'headerOptions' => ['width' => '40'],
                'buttons' => [
                   'reg' => function ($url, $model, $key){
                      return Html::a('', ['registration/create', 'pre_reg_id'=>$model->id], ['class' => 'glyphicon glyphicon-star']);
                   },
                ]
            ],
            'tur_id',
            'class',
            'dancer1_name',
            'dancer1_sname',
            'dancer2_name',
            'dancer2_sname',
            'city',
            'club',
            'trener_name',
            'trener_sname',
        ],
    ]); ?>
</div>
