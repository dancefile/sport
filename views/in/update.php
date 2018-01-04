<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\In */

$this->title = 'Update In: ' . $in->id;
$this->params['breadcrumbs'][] = ['label' => 'Ins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $in->id, 'url' => ['view', 'id' => $in->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="in-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'in' => $in,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
