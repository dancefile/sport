<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dance */

$this->title = 'Create Dance';
$this->params['breadcrumbs'][] = ['label' => 'Dances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
