<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DancerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dancer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sname') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'clas_id_st') ?>

    <?php // echo $form->field($model, 'clas_id_la') ?>

    <?php // echo $form->field($model, 'booknumber') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'club') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
