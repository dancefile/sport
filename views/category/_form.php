<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Otd;
use app\models\Judge;
 

$this->registerJsFile('sport/web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('sport/web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('css/jquery-ui.css');

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php
            $otd = Otd::find()->all();
            $items = ArrayHelper::map($otd,'id','name');
            echo $form->field($model, 'otd_id')->dropDownList($items);
        ?>

        <?= $form->field($model, 'agemin')->textInput() ?>

        <?= $form->field($model, 'agemax')->textInput() ?>
        
        <?= $form->field($model, 'solo')
            ->radioList(
                $model->getSoloList(),
            [
                'enableLabel' => false,
            ]);
            
        ?>
        

        <?= $form->field($model, 'program')
            ->radioList($model->getProgrammList()); 
        ?>

        <?= $form->field($model, 'skay')
            ->radioList([
                '1' => 'Баллы',
                '2' => 'Кресты',
                '3' => 'Скейтинг'
            ]); 
        ?>
        
        <?= $form->field($model, 'dances')
            ->checkboxList($model->danceList);
        ?> 
        
        <!--<input type="submit" id="save" value="ok">-->

        

        <?= $form->field($model, 'clas')
            ->checkboxList([
                'N' => 'N',
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
                'D' => 'D',
                'E' => 'E',
            ]);
        ?>
        
        <?= $form->field($model, 'chesses_list')
            ->checkboxList(
                $judge_list
            );
        ?>
        

        

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            
        </div>

    <?php ActiveForm::end(); ?>

</div>
