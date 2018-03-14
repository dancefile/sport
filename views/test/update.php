<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chess */

$this->title = 'Update Chess: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chess-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
