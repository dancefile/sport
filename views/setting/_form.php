<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comp_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comp_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comp_org')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
