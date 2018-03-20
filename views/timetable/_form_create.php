<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Otd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timetable-form">

    <h1>Отделение №<?= $otd_name ?></h1>
    
    <?php $form = ActiveForm::begin(); ?>
        
    
    
        
        <?= $form
            ->field($model, 'tur_time')
            ->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_TIME,
                'options' => ['value' => '00:01:00'],
            ])
            ->label('Длительность');
        ?>
        <?= $form->field($model, 'category_name')
                ->textInput()
                ->label('Название');
        ?>
        <?= $form->field($model, 'custom')
                ->checkbox([
                    'label' => 'Не удалять при обновлении',
                    'checked ' => true,
                ]);
        ?>

        

        

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>