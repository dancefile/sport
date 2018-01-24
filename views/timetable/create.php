<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Timetable */

$this->title = 'Create Timetable';
$this->params['breadcrumbs'][] = ['label' => 'Timetables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timetable-create">

    <?= $this->render('_form_create', [
        'model' => $model,
        'otd_id' => $otd_id,
        'otd_name' => $otd_name,
    ]) ?>

</div>
