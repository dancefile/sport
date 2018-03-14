<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreRegistration */

$this->title = 'Create Pre Registration';
$this->params['breadcrumbs'][] = ['label' => 'Pre Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
