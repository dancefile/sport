<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
// $turInfo->gettur('')
$this->title = 'Заходы '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 
 echo Html::a('Заходы для участников ', ['index','idT'=>$turInfo->getTur('idT')], ['class' => 'btn btn-success']);
    $columns=[[
           	    'header' => 'Номер',
               	'attribute' => 'nomer',
    	       ],
			  [
           	    'header' => 'Участники',
               	'attribute' => 'name',
               	'format' => 'raw',
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
    $data=[];
	$heatsArr=$turInfo->getHeats();
	var_dump($heatsArr);
	$inArr=$turInfo->getIn();
	asort($inArr);
	 
    foreach ($inArr as $key => $nomer): 
    	$data[$key] = [	'nomer' => $nomer,
    					'name'=>$turInfo->GetCoupleName($key,'fname',', '),
    					'club'=>$turInfo->GetCoupleName($key,'clubName',', '),
    					'City'=>$turInfo->GetCoupleCity($key,'cityName',', '),
    					'Trener'=>$turInfo->GetCoupleTrener($key,', '),
    					
    					];
		
    endforeach;

    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
    $columns=[[
           	    'header' => 'Заход',
               	'attribute' => 'heats',
    	       ],
			  [
           	    'header' => 'пары',
               	'attribute' => 'couple',
    	       ],
				];

foreach ($arrDance as $key => $dance){
echo '<h3>'. Html::encode($dance).'</h3>';	
$data=[];

if (isset($heatsArr[$key])) {
	var_dump($heatsArr[$key]);
	foreach ($heatsArr[$key] as $key1 => $value1) {
				$data[$key1]['couple']=$key;			
			}
		}
    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
}
 echo Html::a('Создать новые заходы', ['new','idT'=>$turInfo->getTur('idT')], ['class' => 'btn btn-success']);
 ?>

</div>