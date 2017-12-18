<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\Otd;
 

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
        <?php
            $otd = Otd::find()->all();
            $items = ArrayHelper::map($otd,'id','name');
            echo $form->field($model, 'otd_id')->dropDownList($items);
        ?>

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
            ],
            [
                'default' => '1'
            ]
            ); 
        ?>

        <table>
            <tbody>
                <tr>
                    <td>
                        <style type="text/css">
                            div.sortable {
                                background-color: lightgrey; 
                                font-size: large;
                                margin: 2px; 
                                text-align: center; 
                                border: medium solid black; 
                                padding: 2px;
                            }
                            #fruitContainer {}
                            #flowerContainer {}
                            div.flower {background-color: lightgrey}
                        </style>

                        

                        <div id="fruitContainer" class="sortContainer ui-sortable" style="background-color: lightgreen;min-width: 100px; min-height: 100px;"></div>
                    </td>
                    <td>
                        <div id="flowerContainer" class="sortContainer ui-sortable" style="background-color: lightgrey;min-width: 100px; min-height: 100px;">
                            <div id="dance_1" class="sortable flower">Ch</div>
                            <div id="dance_2" class="sortable flower">Sa</div>
                            <div id="dance_3" class="sortable flower">R</div>
                            <div id="dance_5" class="sortable flower">J</div>
                            <div id="dance_4" class="sortable flower">Pd</div>
                            <div id="dance_8" class="sortable flower">Wv</div>
                            <div id="dance_9" class="sortable flower">Sf</div>
                            <div id="dance_10" class="sortable flower">Q</div>     
                        </div> 
                    </td>
                </tr>
            </tbody>
        </table>
        <!--<input type="submit" id="save" value="ok">-->

        <?= $form->field($model, 'agemin')->textInput() ?>

        <?= $form->field($model, 'agemax')->textInput() ?>

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

        <?= $form->field($model, 'dances')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
