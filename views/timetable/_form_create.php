<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Otd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timetable-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form
            ->field($model, 'time')
            ->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_TIME
            ])
            ->label(false);
        ?>
        <?= $form->field($model, 'category_name')->textInput() ?>

        <?= $form->field($model, 'tur_name')->textInput() ?>

        

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>