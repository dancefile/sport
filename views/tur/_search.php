<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TurSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tur-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'nomer') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'zahodcount') ?>

    <?php // echo $form->field($model, 'typezahod') ?>

    <?php // echo $form->field($model, 'dances') ?>

    <?php // echo $form->field($model, 'ParNextTur') ?>

    <?php // echo $form->field($model, 'typeSkating') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
