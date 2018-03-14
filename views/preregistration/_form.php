<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PreRegistration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pre-registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dancer1_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dancer1_sname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dancer2_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dancer2_sname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'club')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trener')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
