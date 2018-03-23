<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = $turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 
 echo Html::a('Заходы для участников ', ['index','idT'=>$turInfo->getTur('idT')], ['class' => 'btn btn-success']);
    $columns=[[
           	    'header' => 'Номер',
               	'attribute' => 'nomer',
        'contentOptions' =>['class' => 'bigtext'],
    	       ],
			  [
           	    'header' => 'Участники',
               	'attribute' => 'name',
               	'format' => 'raw',
                              'contentOptions' =>['class' => 'bigtext'],
    	       ],
    	       			  [
           	    'header' => 'Клуб',
               	'attribute' => 'club',
               	'format' => 'raw',
    	       ],
   			  [
           	    'header' => 'Город',
               	'attribute' => 'City',
               	'format' => 'raw',
    	       ],
   			  [
           	    'header' => 'Тренеры',
               	'attribute' => 'Trener',
               	'format' => 'raw',
    	       ]];
 //   $data=[];
//	$heatsArr=$turInfo->getHeats();
	//$inArr=$turInfo->getIn();
        
    echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns
]);
    $columns=[[
           	    'header' => 'Заход',
               	'attribute' => 'heats',
        
    	       ],
			  [
           	    'header' => 'пары',
               	'attribute' => 'couple',
                'contentOptions' =>['class' => 'bigtext'],
    	       ],
				];

$turInfo->SetZahodDancerArr($arrDance);
foreach ($arrDance as $idDance => $dance){
echo '<h3>'. Html::encode($dance).'</h3>';

echo GridView::widget([
    'dataProvider' => $turInfo->heatProvider($idDance),
    'columns' => $columns
]);
}
 echo Html::a('Создать новые заходы', ['new','idT'=>$turInfo->getTur('idT')], ['class' => 'btn btn-success']);
 ?>

</div>