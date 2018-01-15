<?php

use yii\helpers\Html;

$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');


/* @var $this yii\web\View */
/* @var $model app\models\In */

//$this->title = 'Create In';
$this->params['breadcrumbs'][] = ['label' => 'Ins', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
	]) ?>
 	
 	
</div>
