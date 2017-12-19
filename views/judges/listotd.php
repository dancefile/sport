<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = 'Список Отделений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

		<? foreach ($otdes as $otd): ?>
     <p>
 <?= Html::a($otd->name, ['shaxmat','otd'=>$otd->id]) ?>
     </p>
<?php endforeach; ?>

</div>