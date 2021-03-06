<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Otd;
use app\models\Judge;
use yii\widgets\Pjax;
 

$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
<?php Pjax::begin(['id' => 'notes']); ?>
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
                $model->soloList,
            [
                'enableLabel' => false,
            ]);
            
        ?>
        

        <?= $form->field($model, 'program')
            ->radioList(
                $model->programmList
//                [
//                    'onchange' => "alert($('#category-program input:radio:checked').val());",
//                ]
                    );
        ?>
    
    
        <?= $form->field($model, 'skay')
            ->radioList($model->skayList); 
        ?>
    
        <?= $form->field($model, 'dances')
            ->checkboxList($model->getDanceList($model->program));
        ?> 
       
        <?= $form->field($model, 'clas')
            ->checkboxList($model->classList);
        ?>
        
        <?= $form->field($model, 'chesses_list')
            ->checkboxList(
                $judge_list
            );
        ?>
        
        <?= $form->field($model, 'type_comp')
            ->radioList($model->typeCompList); 
        ?>
    
        <?= $form->field($model, 'dancing_order')
            ->radioList($model->dancingOrderList); 
        ?>

        

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            
        </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
