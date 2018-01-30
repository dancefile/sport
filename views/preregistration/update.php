<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PreRegistration */

$this->title = 'Update Pre Registration: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Pre Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pre-registration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
