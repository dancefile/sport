<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimetableSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timetable-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'otd') ?>

    <?= $form->field($model, 'time') ?>

    <?= $form->field($model, 'tur_number') ?>

    <?= $form->field($model, 'category_name') ?>

    <?php // echo $form->field($model, 'tur_id') ?>

    <?php // echo $form->field($model, 'reg_pairs') ?>

    <?php // echo $form->field($model, 'programm') ?>

    <?php // echo $form->field($model, 'dances') ?>

    <?php // echo $form->field($model, 'heats_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
