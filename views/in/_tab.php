<?php
    use yii\helpers\Html;
    use kartik\grid\GridView;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;
?>


<?php $form = ActiveForm::begin(['action' => ['replace'],'options' => ['method' => 'post']]); ?>
    <?php $this->registerJs(
            "$('.kv-row-select').click(function(){
                var keys = [];
                $('#tab').find('input[type=checkbox]:checked').each(function(){
                    keys.push($(this).val());
                });
                $('#replace_ins$otd_id').val(keys);
                $('#otd_id$otd_id').val($otd_id);
            });"      
    );?>

    <div class="form-group">
        <input id="replace_ins<?=$otd_id?>" type="hidden" name="replace_ins" value="" />
        <input id="otd_id<?=$otd_id?>" type="hidden" name="otd_id" value="" />
        
        <?= Html::dropDownList('new-category-id',' ' ,ArrayHelper::map(\app\models\In::getCategories(null), 'id', 'name')) ?>
        <?= Html::submitInput('Переместить', ['id' => 'replace-btn'.$otd_id, 'name'=>'replace', 'class' => 'btn btn-success replace-btn']) ?>
        <?= Html::submitInput('Копировать', ['id' => 'copy-btn'.$otd_id, 'name'=>'copy', 'class' => 'btn btn-success replace-btn']) ?>
    </div>  
<?php $form = ActiveForm::end() ?>


<?= GridView::widget([
        'id' => 'tab',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' =>  [
            ['content' => 
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['registration/create'], ['class' => 'btn btn-success']) 
            ],
            '{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'columns' => [
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model['inId']];
                        }
            ],
            
            [
                'attribute'=>'category', 
                'group'=>true,
                'groupedRow' => true,
                'groupOddCssClass'=>'category-caption',  // configure odd group cell css class
                'groupEvenCssClass'=>'category-caption', // configure even group cell css class
            ],
            [
                'attribute'=>'tur', 
                'group'=>true,
                'groupedRow' => true,
                'groupOddCssClass'=>'tur-caption',  // configure odd group cell css class
                'groupEvenCssClass'=>'tur-caption', // configure even group cell css class
            ],
            
            [
                'attribute' => 'number',
                'options' => ['width' => '50'],
            ],
            [
                'attribute' => 'couple.age',
                'options' => ['width' => '60'],
            ],
            [
                'attribute' => 'dancer1',
                'options' => ['width' => '170'],
                'value' => function($model){
                    if ($model['who'] == 1 || $model['who'] == 3){
                        return $model['dancer1'];
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'classes',
                'options' => ['width' => '50'],
                'value' => function($model) use ($class_list){
                    if ($model['who'] == 1 || $model['who'] == 3){
                        if ($model['classSt1']){
                            $classes[] = $class_list[$model['classSt1']]. '(St)';
                        }
                        if ($model['classLa1']){
                            $classes[] = $class_list[$model['classLa1']]. '(La)';
                        }
                        if (isset($classes)){
                            return implode(' ', $classes);
                        }
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'dancer2',
                'options' => ['width' => '170'],
                'value' => function($model){
                    if ($model['who'] == 2 || $model['who'] == 3){
                        return $model['dancer2'];
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'classes',
                'options' => ['width' => '50'],
                'value' => function($model) use ($class_list){
                    if ($model['who'] == 2 || $model['who'] == 3){
                        if ($model['classSt2']){
                            $classes[] = $class_list[$model['classSt2']]. '(St)';
                        }
                        if ($model['classLa2']){
                            $classes[] = $class_list[$model['classLa2']]. '(La)';
                        }
                        if (isset($classes)){
                            return implode(' ', $classes);
                        }
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'city',
                'value' => function($model){
                    if ($model['city1'] == $model['city2']){
                        return $model['city1'];
                    } else {
                        return $model['city1']. ' '. $model['city2'];
                    }
                }
            ],
                    
            [
                'attribute' => 'club',
//                'options' => ['width' => '50'],
                'value' => function($model){
                    if ($model['club1'] == $model['club2']){
                        return $model['club1'];
                    } else {
                        return $model['club1']. ' '. $model['club2'];
                    }
                }
            ],
             
            [
                'attribute' => 'treners',
                'value' => function($model){
                    if ($model['treners1'] == $model['treners2']){
                        return $model['treners1'];
                    } else {
                        return $model['treners1'].' '.$model['treners2'];
                    }
                    
                }
            ],
           

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'headerOptions' => ['width' => '60'],
                'buttons' => [
                   'update' => function ($url, $model, $key){
                      return Html::a('', 
                              ['registration/update', 
                                  'id'=>$model['inId']], ['class' => 'glyphicon glyphicon-pencil']);
                   },
                   'delete' => function ($url, $model, $key){
                      return Html::a('', 
                              ['in/delete', 
                                  'id'=>$model['inId']], ['class' => 'glyphicon glyphicon-trash', 
                                      'data'=>['method' => 'post']]);
                   }
                ]
            ],
        ],
    ]); 
?>


