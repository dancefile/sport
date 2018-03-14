<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chess */

$this->title = 'Create Chess';
$this->params['breadcrumbs'][] = ['label' => 'Chesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chess-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
