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
                $('#replace_ins$otd_id').val($('#tab$otd_id').yiiGridView('getSelectedRows'));
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
        'id' => 'tab'.$otd_id,
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
                'class' => '\kartik\grid\CheckboxColumn'
            ],
            [
                'attribute'=>'tur.category.name', 
                'group'=>true,
                'groupedRow' => true,
                'groupOddCssClass'=>'category-caption',  // configure odd group cell css class
                'groupEvenCssClass'=>'category-caption', // configure even group cell css class
            ],
            [
                'attribute'=>'tur.name', 
                'group'=>true,
                'groupedRow' => true,
                'groupOddCssClass'=>'tur-caption',  // configure odd group cell css class
                'groupEvenCssClass'=>'tur-caption', // configure even group cell css class
            ],
            
            [
                'attribute' => 'nomer',
                'options' => ['width' => '50'],
            ],
            [
                'attribute' => 'couple.age',
                'options' => ['width' => '60'],
            ],
            [
                'attribute' => 'dancerId1',
                'options' => ['width' => '170'],
                'value' => function($model){
                    if ($model->who == 1 || $model->who == 3){
                        return $model->couple->dancerId1 ? $model->couple->dancerId1->dancerFullName : NULL;
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'classes',
                'options' => ['width' => '50'],
                'value' => function($model) use ($class_list){
                    if ($model->who == 1 || $model->who == 3){
                        if ($model->couple->dancerId1->clas_id_st){
                            $classes[] = $class_list[$model->couple->dancerId1->clas_id_st]. '(St)';
                        }
                        if ($model->couple->dancerId1->clas_id_la){
                            $classes[] = $class_list[$model->couple->dancerId1->clas_id_la]. '(La)';
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
                'attribute' => 'dancerId2',
                'options' => ['width' => '170'],
                'value' => function($model){
                    if ($model->who == 2 || $model->who == 3){
                        return $model->couple->dancerId2 ? $model->couple->dancerId2->dancerFullName : NULL;
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'classes',
                'options' => ['width' => '50'],
                'value' => function($model) use ($class_list){
                    if ($model->who == 2 || $model->who == 3){
                        if ($model->couple->dancerId2->clas_id_st){
                            $classes[] = $class_list[$model->couple->dancerId2->clas_id_st]. '(St)';
                        }
                        if ($model->couple->dancerId2->clas_id_la){
                            $classes[] = $class_list[$model->couple->dancerId2->clas_id_la]. '(La)';
                        }
                        if (isset($classes)){
                            return implode(' ', $classes);
                        }
                    } else {
                        return '-';
                    }
                }
            ],
            'city',
            [
                'attribute' => 'club',
//                'options' => ['width' => '50'],
                'value' => function($model) use ($club_list){
//                    echo '<pre>', print_r($model->couple->dancerId1->club0), '</pre>';
//                    exit;
                    if (isset($model->couple->dancerId1->club)){
                        $clubs[] = $club_list[$model->couple->dancerId1->club];
                    }
                    if (isset($model->couple->dancerId2->club0->city)){
                        $clubs[] = $club_list[$model->couple->dancerId2->club];
                    }
                    if (isset($clubs)){
                        return implode(', ', $clubs);
                    }
                }
            ],
                    

            'couple.trenersString',            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'headerOptions' => ['width' => '60'],
                'buttons' => [
                   'update' => function ($url, $model, $key){
                      return Html::a('', 
                              ['registration/update', 
                                  'id'=>$model->id], ['class' => 'glyphicon glyphicon-pencil']);
                   },
                   'delete' => function ($url, $model, $key){
                      return Html::a('', 
                              ['in/delete', 
                                  'id'=>$model->id], ['class' => 'glyphicon glyphicon-trash', 
                                      'data'=>['method' => 'post']]);
                   }
                ]
            ],
        ],
    ]); 
?>


