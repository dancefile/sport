<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Couple */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="couple-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dancer_id_1')->textInput() ?>

    <?= $form->field($model, 'dancer_id_2')->textInput() ?>

    <?= $form->field($model, 'nomer')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
