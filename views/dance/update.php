<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dance */

$this->title = 'Update Dance: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Dances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
