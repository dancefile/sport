<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Select2;

use yii\web\JsExpression;

use app\models\In;
use app\models\Registration;
use app\models\Couple;
use app\models\Clas;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\In */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="in-form">
    <?php $form = ActiveForm::begin(); ?>
    	<div class=" flex-container">
            <div class="leftBlock flex-item one">
            	<?= $form
                    ->field($model, 'd1_sname')
                    ->textInput(['placeholder' => 'фамилия'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($model, 'd1_name')
                    ->textInput(['placeholder' => 'Имя'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($model, 'd1_date')
                    ->widget(DateControl::classname(), [
                        // 'type' => DatePicker::TYPE_INPUT,
                        'value' => '',
                        'options' => ['placeholder' => 'ДР'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd-M-yyyy'
                        ]
                    ])
                    ->label(false);
                ?>
                <?= $form
                    ->field($model, 'd1_class_st')
                	->dropDownList($model->classList,['prompt' => 'Класс St'])
                	->label(false) 
                ?>
                <?= $form->field($model, 'd1_class_la')
                	->dropDownList($model->classList,['prompt' => 'Класс La'])
                	->label(false) 
                ?>
                <?= $form
                    ->field($model, 'd1_booknumber')
                    ->textInput(['placeholder' => 'Номер книжки'])
                    ->label(false) 
                ?>

            	<br>

            	<?= $form
                    ->field($model, 'd2_sname')
                    ->textInput(['placeholder' => 'фамилия'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($model, 'd2_name')
                    ->textInput(['placeholder' => 'Имя'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($model, 'd2_date')
                    ->widget(DateControl::classname(), [
                        // 'type' => DatePicker::TYPE_INPUT,
                        'value' => '',
                        'options' => ['placeholder' => 'ДР'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd-M-yyyy'
                        ]
                    ])
                    ->label(false);
                ?>
                <?= $form
                    ->field($model, 'd2_class_st')
                	->dropDownList($model->classList,['prompt' => 'Класс St'])
                	->label(false) 
                ?>
                <?= $form->field($model, 'd2_class_la')
                	->dropDownList($model->classList,['prompt' => 'Класс La'])
                	->label(false) 
                ?>
                <?= $form
                    ->field($model, 'd2_booknumber')
                    ->textInput(['placeholder' => 'Номер книжки'])
                    ->label(false) 
                ?>

                <br>
             	
                <?= $form
                    ->field($model, 'club')
                    ->widget(TypeaheadBasic::classname(), [
                        'data' => $model->clubList,
                        'options' => ['placeholder' => 'Клуб'],
                        'pluginOptions' => ['highlight'=>true],
                    ])
                    ->label(false);
                ?>

                <?= $form
                    ->field($model, 'city')
                    ->widget(TypeaheadBasic::classname(), [
                        'data' => $model->cityList,
                        'options' => ['placeholder' => 'Город'],
                        'pluginOptions' => ['highlight'=>true],
                    ])
                    ->label(false);
                ?>

                <?= $form
                    ->field($model, 'country')
                    ->widget(TypeaheadBasic::classname(), [
                        'data' => $model->countryList,
                        'options' => ['placeholder' => 'Страна'],
                        'pluginOptions' => ['highlight'=>true],
                    ])
                    ->label(false); 
                ?>

                <br>
                <div id="trener_list">
                    <div id="trener_1" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener1_sname')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $model->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener1_name')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $model->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                        
                    </div>
                    <div class="showTrener trener_1"><i class="glyphicon glyphicon-minus"></i></div> 
                    <div id="trener_2" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener2_sname')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $model->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener2_name')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $model->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_2"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_3" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener3_sname')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $model->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener3_name')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $model->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_3"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_4" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener4_sname')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $model->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener4_name')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $model->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_4"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_5" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener5_sname')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $model->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener5_name')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $model->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_5"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_6" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener6_sname')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $model->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener6_name')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $model->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_6"><i class="glyphicon glyphicon-plus"></i></div> 
                </div>     	
            </div>

            <div class="rightBlock flex-item two">

                <h3>Пары</h3>
                <table class="turs">
            	<?php          //Вывод таблицы с категориями для пар
                    $otd = 0;
                    $inPair = $model->inPair? $model->inPair:$model->turListPair();
                    
                    foreach ($inPair as $tur) {
                        if ($otd <> $tur['otd']) {
                            $otd = $tur['otd'];    
                            printf ('<tr class="colaps"> <td colspan="3">Отделение %s</td></tr>', $otd);
                        }
                        echo ('<tr class="turRow"><td class="number">');
						if (!isset($tur['nomer'])) $tur['nomer']='';

                        echo Html::input('text', sprintf('Registration[%s][%s]', 'turPair', $tur['id']), $tur['nomer'], ['class' => '']);
                        printf("</td> <td>%s, %s</td> </tr>", $tur['id'], $tur['name']);            
                    }
                ?>
                </table>

                <br><br>
                <h3>Соло</h3>

                <table class="turs">
                <?php          //Вывод таблицы с категориями для соло
                    $otd = 0;
                    $inSolo = $model->inSolo? $model->inSolo:$model->turListSolo();

                    foreach ($inSolo as $tur) {
                        if ($otd <> $tur['otd']) {
                            $otd = $tur['otd'];    
                            printf ('<tr class="colaps"> <td colspan="3">Отделение %s</td></tr>', $otd);
                        }
												if (!isset($tur['nomer_M'])) $tur['nomer_M']='';
						if (!isset($tur['nomer_W'])) $tur['nomer_W']='';
                        echo '<tr class="turRow"> <td class="number">';
                        echo Html::input('text', sprintf('Registration[%s][%s]', 'turSolo_M', $tur['id']), $tur['nomer_M'], ['class' => '']);
                        echo '</td><td class="number">';
                        echo Html::input('text', sprintf('Registration[%s][%s]', 'turSolo_W', $tur['id']), $tur['nomer_W'], ['class' => '']);
                        printf("</td> <td>%s, %s</td> </tr>", $tur['id'], $tur['name']);
                    }
                    
                ?>
                </table>
            </div>
        </div>
        <div class="form-group three">
            <?= Html::submitButton('Create', 
                ['class' => 'btn btn-success']) 
            ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>