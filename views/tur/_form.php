<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use kartik\datecontrol\DateControl;
 

$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');

/* @var $this yii\web\View */
/* @var $model app\models\Tur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $category = Category::find()->all();
        $items = ArrayHelper::map($category,'id','name');
        echo $form->field($model, 'category_id')->dropDownList($items);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomer')->textInput() ?>

    <?= $form->field($model, 'zahodcount')->textInput() ?>

    <?= $form->field($model, 'ParNextTur')->textInput() ?>
    
    <?= $form
        ->field($model, 'turTime')
        ->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_TIME
        ])
        ->label(false);
    ?>
    

<div> </div>

    <?= $form->field($model, 'typezahod')
        ->radioList($model->typezahodList); 
    ?>

    <?= $form->field($model, 'typeSkating')
        ->radioList($model->category->skayList); 
    ?>

    <?= $form->field($model, 'dances')
        ->checkboxList($model->danceList);
    ?>  

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
