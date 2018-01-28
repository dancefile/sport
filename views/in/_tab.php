<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;



?>
<?php \yii\widgets\Pjax::begin()?>

<?= $this->render('_left_panel', ['otd_id'=>$otd_id]); ?>

<?php $categories = \app\models\In::getCategories('');?>

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
        
        <?= Html::dropDownList('new-category-id',' ' ,ArrayHelper::map($categories, 'id', 'name')) ?>
        <?= Html::submitButton('Переместить', ['id' => 'replace-btn'.$otd_id, 'class' => 'btn btn-success replace-btn']) ?>
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


