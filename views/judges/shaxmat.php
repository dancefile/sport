<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Шахматка отд.#' . $otdname;
$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <style>
        .vertical-text {
            height: 200px;
            -webkit-writing-mode: vertical-rl;
        }
    </style>
    <?php
    $columns = ['name'];
    foreach ($Categories as $cat):
        $columns[] = [
            'header' => '<div  class="vertical-text">' . $cat->name . '</div>',
            'attribute' => 's' . $cat->id,
            'options' => ['class' => 'vertical-text'],
        ];
    endforeach;
    
    $data = [];
    foreach ($Judges as $Judg):
        $data[$Judg->id] = ['name' => $Judg->sname . ' ' . $Judg->name];
    endforeach;

    foreach ($Chess as $Ches):
        $data[$Ches->judge_id] = array_merge($data[$Ches->judge_id], ['s' . $Ches->category_id => $Ches->nomer]); // (($Ches->chief) ? ' chief' : '')]);
    endforeach;
    
    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' =>
        [
            'pageSize' => 10,
        ],
        'sort' =>
        [
            'attributes' => ['id', 'name', 'sname'],
        ],
    ]);
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $provider,
        'columns' => $columns
    ]);
    ?>

</div>