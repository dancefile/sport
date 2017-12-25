<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

use yii\web\JsExpression;

use app\models\In;
use app\models\Dancer;

/* @var $this yii\web\View */
/* @var $model app\models\In */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="in-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($in, 'tur_id')->textInput() ?>

	<?= $form->field($couple, 'dancer_id_1')->textInput() ?>

    <?= $form->field($couple, 'dancer_id_2')->textInput() ?>

    <?= $form->field($couple, 'nomer')->textInput() ?>

 

    <div class="form-group">
        <?= Html::submitButton($in->isNewRecord ? 'Create' : 'Update', ['class' => $in->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
