<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Select2;

use yii\web\JsExpression;

use app\models\In;
use app\models\Couple;
use app\models\Clas;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\In */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="in-form">

    

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($in, 'dancer1[sname]')->textInput(['placeholder' => 'фамилия'])->label(false) ?>
    <?= $form->field($in, 'dancer1[name]')->textInput(['placeholder' => 'Имя'])->label(false) ?>
    <?= $form->field($in, 'dancer1[date]')->textInput(['placeholder' => 'ДР'])->label(false) ?>
    <?= $form->field($in, 'dancer1[clas_id_st]')
    	->dropDownList($in->classList,['prompt' => 'Класс St'])
    	->label(false) 
    ?>
    <?= $form->field($in, 'dancer1[clas_id_la]')
    	->dropDownList($in->classList,['prompt' => 'Класс La'])
    	->label(false) 
    ?>
    <?= $form->field($in, 'dancer1[booknumber]')->textInput(['placeholder' => 'Номер книжки'])->label(false) ?>

	<br><br>
	<?= $form->field($in, 'dancer2[sname]')->textInput(['placeholder' => 'фамилия'])->label(false) ?>
    <?= $form->field($in, 'dancer2[name]')->textInput(['placeholder' => 'Имя'])->label(false) ?>
    <?= $form->field($in, 'dancer2[date]')->textInput(['placeholder' => 'ДР'])->label(false) ?>
    <?= $form->field($in, 'dancer2[clas_id_st]')
    	->dropDownList($in->classList,['prompt' => 'Класс St'])
    	->label(false) 
    ?>
    <?= $form->field($in, 'dancer2[clas_id_la]')
    	->dropDownList($in->classList,['prompt' => 'Класс La'])
    	->label(false) 
    ?>
    <?= $form->field($in, 'dancer2[booknumber]')->textInput(['placeholder' => 'Номер книжки'])->label(false) ?>

    <br><br>
 	
    
    <?= $form->field($in, 'common[club]')->widget(Select2::classname(), [
            // 'name' => 'color_3',
            // 'value' => $in->currentClub, // initial value
            'data' => $in->clubList,
            'options' => ['placeholder' => 'Клуб'],
            'pluginOptions' => [
                'tags' => true,
                // 'tokenSeparators' => [',', ' '],
                // 'maximumInputLength' => 10
            ],
        ]);
    ?>


    <?= $form->field($in, 'common[city]')->widget(TypeaheadBasic::classname(), [
        'data' => $in->cityList,
        'options' => ['placeholder' => 'Город'],
        'pluginOptions' => ['highlight'=>true],
    ]);?>



    <?= $form->field($in, 'common[country]')->textInput(['placeholder' => 'Страна'])->label(false) ?>
	
	<?php 
		echo GridView::widget([
            'id' => 'grid-reg',
            'dataProvider' => $dataProvider,
            'pjax' => true,
            'condensed' => true,
            'columns' => [
                [
                    'attribute'=>'otd_id', 
                    'value'=>function ($model, $key, $index, $widget) { 
                        return 'Отделение ' . $model->category->otd->name;
                    },
                    'group'=>true,
                    'groupedRow' => true,
                ],
                [
                    'class' => '\kartik\grid\CheckboxColumn'
                ],
                'id',
                'category.name',
            ], 
        ]);
	?>

    <div class="form-group">
        <?= Html::submitButton($in->isNewRecord ? 'Create' : 'Update', 
            ['class' => $in->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>