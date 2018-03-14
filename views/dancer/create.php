<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dancer */

$this->title = 'Create Dancer';
$this->params['breadcrumbs'][] = ['label' => 'Dancers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dancer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
