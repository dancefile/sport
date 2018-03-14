<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PreRegistrationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pre-registration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'class') ?>

    <?= $form->field($model, 'dancer1_name') ?>

    <?= $form->field($model, 'dancer1_sname') ?>

    <?php // echo $form->field($model, 'dancer2_name') ?>

    <?php // echo $form->field($model, 'dancer2_sname') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'club') ?>

    <?php // echo $form->field($model, 'trener') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
