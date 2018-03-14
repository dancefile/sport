<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'solo') ?>

    <?= $form->field($model, 'otd') ?>

    <?= $form->field($model, 'program') ?>

    <?php // echo $form->field($model, 'agemin') ?>

    <?php // echo $form->field($model, 'agemax') ?>

    <?php // echo $form->field($model, 'age_id') ?>

    <?php // echo $form->field($model, 'clas') ?>

    <?php // echo $form->field($model, 'skay') ?>

    <?php // echo $form->field($model, 'dances') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
