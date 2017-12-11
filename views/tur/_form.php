<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'nomer')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zahodcount')->textInput() ?>

    <?= $form->field($model, 'typezahod')->textInput() ?>

    <?= $form->field($model, 'dances')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ParNextTur')->textInput() ?>

    <?= $form->field($model, 'typeSkating')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
