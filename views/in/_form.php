<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
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
 	<?= $form->field($in, 'common[club]')->textInput(['placeholder' => 'Клуб'])->label(false) ?>
    <?= $form->field($in, 'common[city]')->textInput(['placeholder' => 'Город'])->label(false) ?>
    <?= $form->field($in, 'common[country]')->textInput(['placeholder' => 'Страна'])->label(false) ?>
	
	<?php 
		echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pjax' => true,
        'condensed' => true,
        // 'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],
        
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

        ],
         
        // 'toolbar' =>  [
        //     ['content' => 
        //         Html::a('<i class="glyphicon glyphicon-plus"></i>', ['category/create'], ['class' => 'btn btn-default']) 
        //     ],
        //     '{export}',
        //     '{toggleData}',
        // ],
        // // set export properties
        // 'export' => [
        //     'fontAwesome' => true
        // ],
        
    ]);
	?>

    <div class="form-group">
        <?= Html::submitButton($in->isNewRecord ? 'Create' : 'Update', ['class' => $in->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>