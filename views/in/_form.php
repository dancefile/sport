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
                    ->field($in, 'dancer1[sname]')
                    ->textInput(['placeholder' => 'фамилия'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($in, 'dancer1[name]')
                    ->textInput(['placeholder' => 'Имя'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($in, 'dancer1[date]')
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
                    ->field($in, 'dancer1[clas_id_st]')
                	->dropDownList($in->classList,['prompt' => 'Класс St'])
                	->label(false) 
                ?>
                <?= $form->field($in, 'dancer1[clas_id_la]')
                	->dropDownList($in->classList,['prompt' => 'Класс La'])
                	->label(false) 
                ?>
                <?= $form
                    ->field($in, 'dancer1[booknumber]')
                    ->textInput(['placeholder' => 'Номер книжки'])
                    ->label(false) 
                ?>

            	<br><br>

            	<?= $form
                    ->field($in, 'dancer2[sname]')
                    ->textInput(['placeholder' => 'фамилия'])
                    ->label(false)
                ?>
                <?= $form
                    ->field($in, 'dancer2[name]')
                    ->textInput(['placeholder' => 'Имя'])
                    ->label(false) 
                ?>
                <?= $form
                    ->field($in, 'dancer2[date]')
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
                <?= $form->field($in, 'dancer2[clas_id_st]')
                	->dropDownList($in->classList,['prompt' => 'Класс St'])
                	->label(false) 
                ?>
                <?= $form
                    ->field($in, 'dancer2[clas_id_la]')
                	->dropDownList($in->classList,['prompt' => 'Класс La'])
                	->label(false) 
                ?>
                <?= $form
                    ->field($in, 'dancer2[booknumber]')
                    ->textInput(['placeholder' => 'Номер книжки'])
                    ->label(false)
                ?>

                <br><br>
             	
                <?= $form
                    ->field($in, 'common[club]')
                    ->widget(TypeaheadBasic::classname(), [
                        'data' => $in->clubList,
                        'options' => ['placeholder' => 'Клуб'],
                        'pluginOptions' => ['highlight'=>true],
                    ])
                    ->label(false);
                ?>

                <?= $form
                    ->field($in, 'common[city]')
                    ->widget(TypeaheadBasic::classname(), [
                        'data' => $in->cityList,
                        'options' => ['placeholder' => 'Город'],
                        'pluginOptions' => ['highlight'=>true],
                    ])
                    ->label(false);
                ?>

                <?= $form
                    ->field($in, 'common[country]')
                    ->widget(TypeaheadBasic::classname(), [
                        'data' => $in->countryList,
                        'options' => ['placeholder' => 'Страна'],
                        'pluginOptions' => ['highlight'=>true],
                    ])
                    ->label(false); 
                ?>

                <br><br>
                <div id="trener_list">
                    <div id="trener_1">
                        <?= $form
                        ->field($in, 'dancer_trener[0][sname]')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $in->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($in, 'dancer_trener[0][name]')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $in->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                        
                    </div>
                    <div class="showTrener trener_1"><i class="glyphicon glyphicon-minus"></i></div> 
                    <div id="trener_2">
                        <?= $form
                        ->field($in, 'dancer_trener[1][sname]')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $in->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($in, 'dancer_trener[1][name]')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $in->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_2"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_3">
                        <?= $form
                        ->field($in, 'dancer_trener[2][sname]')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $in->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($in, 'dancer_trener[2][name]')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $in->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_3"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_4">
                        <?= $form
                        ->field($in, 'dancer_trener[3][sname]')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $in->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($in, 'dancer_trener[3][name]')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $in->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_4"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_5">
                        <?= $form
                        ->field($in, 'dancer_trener[4][sname]')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $in->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($in, 'dancer_trener[4][name]')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $in->trenerNameList,
                                'options' => ['placeholder' => 'Имя тренера'],
                                'pluginOptions' => ['highlight'=>true],
                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_5"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_6">
                        <?= $form
                        ->field($in, 'dancer_trener[5][sname]')
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $in->trenerSnameList,
                            'options' => ['placeholder' => 'Фамилия тренера'],
                            'pluginOptions' => ['highlight'=>true],
                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($in, 'dancer_trener[5][name]')
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $in->trenerNameList,
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
                    foreach (In::turListPair() as $tur) {
                        if ($otd <> $tur['otd']) {
                            $otd = $tur['otd'];    
                            printf ('<tr class="colaps"> <td colspan="3">Отделение %s</td></tr>', $otd);
                        }
                        echo ('<tr class="turRow"><td class="number">');
                        echo Html::input('text', 'In[turPair][' . $tur['id'] . ']', '', ['class' => '']);
                        printf("</td> <td> %s</td> </tr>", $tur['name']);            
                    }
            	
                ?>
                </table>

                <br><br>
                <h3>Соло</h3>

                <table class="turs">
                <?php          //Вывод таблицы с категориями для соло
                    $otd = 0;
                    foreach (In::turListSolo() as $tur) {
                        if ($otd <> $tur['otd']) {
                            $otd = $tur['otd'];    
                            printf ('<tr class="colaps"> <td colspan="3">Отделение %s</td></tr>', $otd);
                        }
                        echo '<tr class="turRow"> <td class="number">';
                        echo Html::input('text', 'In[turSolo_M][' . $tur['id'] . ']', '', ['class' => '']);
                        echo '</td><td class="number">';
                        echo Html::input('text', 'In[turSolo_W][' . $tur['id'] . ']', '', ['class' => '']);
                        printf("</td> <td> %s</td> </tr>", $tur['name']);
                    }
                
                ?>
                </table>
            </div>
        </div>
        <div class="form-group three">
            <?= Html::submitButton($in->isNewRecord ? 'Create' : 'Update', 
                ['class' => $in->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
            ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>