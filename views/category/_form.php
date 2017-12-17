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
            ->checkbox([
                'label' => 'Соло',
                'labelOptions' => [
                    'style' => 'padding-left:20px;'
                ],
                'disabled' => false
            ]); ?>

        <?= $form->field($model, 'otds')->textInput() ?>

        <?= $form->field($model, 'program')->textInput() ?>

        <?= $form->field($model, 'agemin')->textInput() ?>

        <?= $form->field($model, 'agemax')->textInput() ?>

        <?= $form->field($model, 'clas')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'skay')->textInput() ?>

        <?= $form->field($model, 'dances')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
