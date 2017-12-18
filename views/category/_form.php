<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        
        <?= $form->field($model, 'solo')
            ->radioList([
                '1' => 'Пары',
                '2' => 'Соло'
            ],
            [
                'enableLabel' => false,
                'template' => '{error}{hint}'
            ]);
            
        ?>

        <?= $form->field($model, 'otds')->textInput()?>

        <?= $form->field($model, 'program')
            ->radioList([
                '1' => 'Latina',
                '2' => 'Standart'
            ]); 
        ?>

        <?= $form->field($model, 'skay')
            ->radioList([
                '1' => 'Баллы',
                '2' => 'Кресты',
                '3' => 'Скейтинг'
            ]); 
        ?>

        <?= $form->field($model, 'agemin')->textInput() ?>

        <?= $form->field($model, 'agemax')->textInput() ?>

        <?= $form->field($model, 'clas')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'dances')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
