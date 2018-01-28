<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


?>
<?php \yii\widgets\Pjax::begin()?>

<?= $this->render('_left_panel', ['otd_id'=>$otd_id]); ?>

<?php $categories = \app\models\In::getCategories('');?>



<?= $this->registerJs(
        "$('#replace-btn').click(function(){
            var new_category_id = $('[name = \"new-category-id\"]').val();
            var replace_ins = $('#w0').yiiGridView('getSelectedRows');
            var otd_id = $otd_id;
            alert (otd_id);
            return false;
        });"      
        );?>

<div class="form-group">
    <?= Html::dropDownList('new-category-id',' ' ,ArrayHelper::map($categories, 'id', 'name')) ?>
    <?= Html::submitButton('Переместить', ['id' => 'replace-btn', 'class' => 'btn btn-success replace-btn']) ?>
</div>  

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'panel'=>['type'=>'primary', 'heading'=>Html::encode($this->title)],
        
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
//                'contentOptions' => ['class'=>'category-caption'],
            ],
            [
                'attribute'=>'tur.name', 
                'group'=>true,
                'groupedRow' => true,
                'groupOddCssClass'=>'tur-caption',  // configure odd group cell css class
                'groupEvenCssClass'=>'tur-caption', // configure even group cell css class
//                'contentOptions' => ['class'=>'colaps'],
            ],
            
            [
                'attribute' => 'couple_nomer',
                'options' => ['width' => '50'],
                'value' => function($model){
                    return $model->nomer;
                }
            ],
            [
                'attribute' => 'couple.age',
                'options' => ['width' => '60'],
            ],
            [
                'attribute' => 'dancerId1',
                'options' => ['width' => '170'],
                'value' => function($model){
                    return $model->couple->dancerId1 ? $model->couple->dancerId1->dancerFullName : NULL;
                }
            ],
            [
                'attribute' => 'couple.dancerId1.classes',
                'options' => ['width' => '50'],
            ],
            [
                'attribute' => 'dancerId2',
                'options' => ['width' => '170'],
                'value' => function($model){
                    return $model->couple->dancerId2 ? $model->couple->dancerId2->dancerFullName : NULL;
                }
            ],
            [
                'attribute' => 'couple.dancerId2.classes',
                'options' => ['width' => '50'],
            ],
            'city',
            'couple.club',
            'couple.trenersString',            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'headerOptions' => ['width' => '60'],
                'buttons' => [
                   'update' => function ($url, $model, $key){
                      return Html::a('', ['registration/update', 'id'=>$model->id], ['class' => 'glyphicon glyphicon-pencil']);
                   },
//                   'delete' => function ($url, $model, $key){
//                      return Html::a('', ['delete'], ['class' => 'glyphicon glyphicon-cancel']);
//                   }
                ]
            ],
        ],
    ]); 
?>
<?php \yii\widgets\Pjax::end()?>


