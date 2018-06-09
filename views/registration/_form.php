<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

use app\models\In;
use app\models\Registration;
use app\models\Couple;
use app\models\Clas;

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\widgets\Typeahead;

use yii\bootstrap\Tabs;


/* @var $this yii\web\View */
/* @var $model app\models\In */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="in-form">
    <?php $form = ActiveForm::begin(); ?>
    	<div class=" flex-container">
            <div class="leftBlock flex-item one">
                          
            	<?= Html::activeHiddenInput($model, 'd1_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd2_id'); ?>
            	<?= Html::activeHiddenInput($model, 'club_id'); ?>
            	<?= Html::activeHiddenInput($model, 'city_id'); ?>
            	<?= Html::activeHiddenInput($model, 'country_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd_trener1_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd_trener2_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd_trener3_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd_trener4_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd_trener5_id'); ?>
            	<?= Html::activeHiddenInput($model, 'd_trener6_id'); ?>
                
                <?php
                    $template = '<div><p>{{sname}} {{name}} {{date}}</p></div>';
                    
                    echo $form->field($model, 'd1_sname')
                        ->widget(Typeahead::classname(), [
                            'options' => [
                                'placeholder' => 'Фамилия',
                                'autofocus' => 'autofocus',
                            ],
                            'dataset' => [
                                [
                                    'display' => 'sname',
                                    'remote' => [
                                        'url' => Url::to(['in/dancer-list']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ],
                                    'limit' => 10,
                                    'templates' => [
                                        'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find repositories for selected query.</div>',
                                        'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                    ]
                                ]
                            ],
                            'pluginEvents' =>  [
                                'typeahead:selected' => 'function(event, data) {find_in(data,"d1");}',
                            ],
                        ])
                        ->label(false)
                    ;
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

            	<?php
                    $template = '<div><p>{{sname}} {{name}} {{date}}</p></div>';
                    
                    echo $form->field($model, 'd2_sname')
                        ->widget(Typeahead::classname(), [
                            'options' => [
                                'placeholder' => 'Фамилия',
                            ],
                            'dataset' => [
                                [
                                    'display' => 'sname',
                                    'remote' => [
                                        'url' => Url::to(['in/dancer-list']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ],
                                    'limit' => 10,
                                    'templates' => [
                                        'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find repositories for selected query.</div>',
                                        'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                    ]
                                ]
                            ],
                            'pluginEvents' =>  [
                                'typeahead:selected' => 'function(event, data) {find_in(data,"d2");}',
                            ],
                        ])
                        ->label(false)
                    ;
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
                            'format' => 'dd-M-yyyy',
                            'placeholder' => 'ДР'
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
                <div id="coupleages"></div>

             	<?php
                    $template = '<div><p>{{club_name}} {{city_name}}</p></div>';
                    
                    echo $form->field($model, 'club')
                        ->widget(Typeahead::classname(), [
                            'options' => [
                                'placeholder' => 'Клуб',
                            ],
                            'dataset' => [
                                [
                                    'display' => 'club_name',
                                    'remote' => [
                                        'url' => Url::to(['in/club-list']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ],
                                    'limit' => 10,
                                    'templates' => [
                                        'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find repositories for selected query.</div>',
                                        'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                    ]
                                ]
                            ],
                            'pluginEvents' =>  [
                                'typeahead:selected' => 'function(event, data) {'
                                . '$("#registration-club_id").val(data.club_id);'
                                . '$("#registration-city_id").val(data.city_id);'
                                . '$("#registration-city").val(data.city_name);'
                                . '$("#registration-country_id").val(data.country_id);'
                                . '$("#registration-country").val(data.country_name);}',
                                'typeahead:autocomplete' => 'function(event, data) {find_in(data,"d2");}'
                            ],
                        ])
                        ->label(false)
                    ;
                ?>
                

                <?= $form
                    ->field($model, 'city')
                    ->textInput(['placeholder' => 'Город'])
//                    ->widget(TypeaheadBasic::classname(), [
//                        'data' => $model->cityList,
//                        'options' => ['placeholder' => 'Город'],
//                        'pluginOptions' => ['highlight'=>true],
//                    ])
                    ->label(false);
                ?>

                <?= $form
                    ->field($model, 'country')
                    ->textInput(['placeholder' => 'Страна'])
//                    ->widget(TypeaheadBasic::classname(), [
//                        'data' => $model->countryList,
//                        'options' => ['placeholder' => 'Страна'],
//                        'pluginOptions' => ['highlight'=>true],
//                    ])
                    ->label(false); 
                ?>

                <br>
                <div id="trener_list">
                    <div id="trener_1" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener1_sname')
                        ->textInput(['placeholder' => 'Фамилия тренера'])
//                        ->widget(TypeaheadBasic::classname(), [
//                            'data' => $model->trenerSnameList,
//                            'options' => ['placeholder' => 'Фамилия тренера'],
//                            'pluginOptions' => ['highlight'=>true],
//                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener1_name')
                            ->textInput(['placeholder' => 'Имя тренера'])
//                            ->widget(TypeaheadBasic::classname(), [
//                                'data' => $model->trenerNameList,
//                                'options' => ['placeholder' => 'Имя тренера'],
//                                'pluginOptions' => ['highlight'=>true],
//                            ])
                            ->label(false); 
                        ?>
                        
                    </div>
                    <div class="showTrener trener_1"><i class="glyphicon glyphicon-minus"></i></div> 
                    <div id="trener_2" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener2_sname',['inputOptions' => [
                                                                    'autocomplete' => 'off',
                                                                    'autocorrect' => 'off']])
                        ->textInput(['placeholder' => 'Фамилия тренера'])
//                        ->widget(TypeaheadBasic::classname(), [
//                            'data' => $model->trenerSnameList,
//                            'options' => ['placeholder' => 'Фамилия тренера'],
//                            'pluginOptions' => ['highlight'=>true],
//                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener2_name')
                            ->textInput(['placeholder' => 'Имя тренера'])
//                            ->widget(TypeaheadBasic::classname(), [
//                                'data' => $model->trenerNameList,
//                                'options' => ['placeholder' => 'Имя тренера'],
//                                'pluginOptions' => ['highlight'=>true],
//                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_2"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_3" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener3_sname',['inputOptions' => [
                                                                    'autocomplete' => 'off',
                                                                    'autocorrect' => 'off']])
                        ->textInput(['placeholder' => 'Фамилия тренера'])
//                        ->widget(TypeaheadBasic::classname(), [
//                            'data' => $model->trenerSnameList,
//                            'options' => ['placeholder' => 'Фамилия тренера'],
//                            'pluginOptions' => ['highlight'=>true],
//                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener3_name')
                            ->textInput(['placeholder' => 'Имя тренера'])
//                            ->widget(TypeaheadBasic::classname(), [
//                                'data' => $model->trenerNameList,
//                                'options' => ['placeholder' => 'Имя тренера'],
//                                'pluginOptions' => ['highlight'=>true],
//                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_3"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_4" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener4_sname',['inputOptions' => [
                                                                    'autocomplete' => 'off',
                                                                    'autocorrect' => 'off']])
                        ->textInput(['placeholder' => 'Фамилия тренера'])
//                        ->widget(TypeaheadBasic::classname(), [
//                            'data' => $model->trenerSnameList,
//                            'options' => ['placeholder' => 'Фамилия тренера'],
//                            'pluginOptions' => ['highlight'=>true],
//                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener4_name')
                            ->textInput(['placeholder' => 'Имя тренера'])
//                            ->widget(TypeaheadBasic::classname(), [
//                                'data' => $model->trenerNameList,
//                                'options' => ['placeholder' => 'Имя тренера'],
//                                'pluginOptions' => ['highlight'=>true],
//                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_4"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_5" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener5_sname',['inputOptions' => [
                                                                    'autocomplete' => 'off',
                                                                    'autocorrect' => 'off']])
                        ->textInput(['placeholder' => 'Фамилия тренера'])
//                        ->widget(TypeaheadBasic::classname(), [
//                            'data' => $model->trenerSnameList,
//                            'options' => ['placeholder' => 'Фамилия тренера'],
//                            'pluginOptions' => ['highlight'=>true],
//                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener5_name')
                            ->textInput(['placeholder' => 'Имя тренера'])
//                            ->widget(TypeaheadBasic::classname(), [
//                                'data' => $model->trenerNameList,
//                                'options' => ['placeholder' => 'Имя тренера'],
//                                'pluginOptions' => ['highlight'=>true],
//                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_5"><i class="glyphicon glyphicon-plus"></i></div> 
                    <div id="trener_6" class="trenerItem">
                        <?= $form
                        ->field($model, 'd_trener6_sname',['inputOptions' => [
                                                                    'autocomplete' => 'off',
                                                                    'autocorrect' => 'off']])
                        ->textInput(['placeholder' => 'Фамилия тренера'])
//                        ->widget(TypeaheadBasic::classname(), [
//                            'data' => $model->trenerSnameList,
//                            'options' => ['placeholder' => 'Фамилия тренера'],
//                            'pluginOptions' => ['highlight'=>true],
//                        ])
                        ->label(false); 
                        ?>
                        <?= $form
                            ->field($model, 'd_trener6_name')
                            ->textInput(['placeholder' => 'Имя тренера'])
//                            ->widget(TypeaheadBasic::classname(), [
//                                'data' => $model->trenerNameList,
//                                'options' => ['placeholder' => 'Имя тренера'],
//                                'pluginOptions' => ['highlight'=>true],
//                            ])
                            ->label(false); 
                        ?>
                    </div>
                    <div class="showTrener trener_6"><i class="glyphicon glyphicon-plus"></i></div> 
                </div>     	
            </div>
            
            

            <div class="rightBlock flex-item two">
                <h3>Пары</h3>
                <hr>
                
                <div class="gender_marker_mw">МЖ</div><p class="list_registrations"></p>
                
                <?php
                    $inPair = $model->inPair? $model->inPair:$model->turListPair();                    
                    if (!empty($_POST)){
                        $turPair = $_POST['Registration']['turPair'];
                        $turSolo_M = $_POST['Registration']['turSolo_M'];
                        $turSolo_W = $_POST['Registration']['turSolo_W'];
                    }
                    
                    $tabs=[];
                    $str='';
                    $otd_count = 0;
                    
                    foreach ($inPair as $key=>$tur) {
                        if (!isset($tur['nomer'])) $tur['nomer']='';
                        if ($key == 0){
                            $tabs[$otd_count]['label'] = $tur['otd'];                           
                        } elseif ($tabs[$otd_count]['label'] <> $tur['otd']) {
                            $tabs[$otd_count]['content'] = $str;
                            $otd_count ++;
                            $str='';
                            $tabs[$otd_count]['label'] = $tur['otd'];
                        }
                        if (isset($turPair)){
                            $number = $turPair[$tur['id']];
                        } else {
                            $number = $tur['nomer'];
                        }
                        $str .= '<div class="registration_tur_item">' .  
                                Html::input('text', sprintf('Registration[%s][%s]', 'turPair', $tur['id']), 
                                        $number, ['class' => '']).
                                '<label>' . $tur["name"]. '</label>'.
                                '</div>';
                        $tabs[$otd_count]['content'] = $str;
                    }
                   
                    echo Tabs::widget([
                        'items' => $tabs
                    ]);
                ?>
                <h3>Соло</h3>
                <hr>
                <div class="gender_marker_m">М</div><p class="list_registrations_solo_M"></p>
                <br>
                <div class="gender_marker_w">Ж</div><p class="list_registrations_solo_W"></p>
                
                <?php
                    $inSolo = $model->inSolo? $model->inSolo:$model->turListSolo();                    
                    $tabs=[];
                    $str='';
                    $otd_count = 0;
                    
                    foreach ($inSolo as $key=>$tur) {
                        if (!isset($tur['nomer_M'])) $tur['nomer_M']='';
                        if (!isset($tur['nomer_W'])) $tur['nomer_W']='';
                        if ($key == 0){
                            $tabs[$otd_count]['label'] = $tur['otd'];
                        } elseif ($tabs[$otd_count]['label'] <> $tur['otd']) {
                            $tabs[$otd_count]['content'] = $str;
                            $otd_count ++;
                            $str='';
                            $tabs[$otd_count]['label'] = $tur['otd'];
                        }
                        if (isset($turSolo_M)){
                            $number_M = $turSolo_M[$tur['id']];
                        } else {
                            $number_M = $tur['nomer_M'];
                        }
                        if (isset($turSolo_W)){
                            $number_W = $turSolo_W[$tur['id']];
                        } else {
                            $number_W = $tur['nomer_W'];
                        }
                        $str .= '<div class="registration_tur_item">' .  
                                Html::input('text', 
                                        sprintf('Registration[%s][%s]', 'turSolo_M', $tur['id']), 
                                        $number_M, ['class' => 'number_m']).
                                Html::input('text', 
                                        sprintf('Registration[%s][%s]', 'turSolo_W', $tur['id']), 
                                        $number_W, ['class' => 'number_w']).
                                '<label>' .$tur["name"]. '</label>' .
                                '</div>';
                        $tabs[$otd_count]['content'] = $str;
                    }
                   
                    echo Tabs::widget([
                        'items' => $tabs
                    ]);
                ?>
            </div>
        </div>
        <div class="form-group three">
            <?= $form->field($model, 'print_check')
                ->checkbox([
                    'label' => 'Печать чека',
                    'labelOptions' => [
                        'style' => 'padding-left:20px;'
                    ],
            ]); ?>
            
            <?= Html::submitButton('Create', 
                ['class' => 'btn btn-success']) 
            ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>




        <div id="search_advice_wrapper"></div>
