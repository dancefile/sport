<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tur */

$this->title = 'Новый тур';
$this->params['breadcrumbs'][] = ['label' => 'Turs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
