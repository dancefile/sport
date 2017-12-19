<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

//$this->title = 'Update Category: ' . $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
$this->title = 'Редактирование судьи';
?>
<div class="category-update">



    <?= $this->render('create', [
        'model' => $model,
    ]) ?>

</div>
