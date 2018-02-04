<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список судей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Добавить судью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'sname',
            'name',
            [
                'attribute' => 'language_id',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->language_id == '2' ? 'Английский' : 'Русский' ;
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
			'header' => false,            
            ],
        ],
    ]); ?>
</div>