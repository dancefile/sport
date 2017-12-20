<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

if (!$this->title) $this->title = 'Добавление судьи';
$this->params['breadcrumbs'][] = ['label' => 'Список судий', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>    
    <div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'sname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'language_id')
            ->radioList([
                '1' => 'Русский',
                '2' => 'Английский'
            ]); 
        ?>

        
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?> 
        
       </div>

    <!--<? //$this->render('_form', [
        //'model' => $model,
   // ]) 
   ?>-->

</div>
