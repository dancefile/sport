<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Otd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="otd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>
    
    <?= $form
        ->field($model, 'startTime')
        ->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_TIME
        ])
        ->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
