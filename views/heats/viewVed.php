<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
// $turInfo->gettur('')
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





foreach ($arrDance as $keyDance => $dance){
	$arr[$keyDance][0]=$inArr;
}


		foreach ($heatsArr as $idcouple => $value1) {
			foreach ($value1 as $iddance => $zahod) {
				unset($arr[$iddance][0][$idcouple]);
				$arr[$iddance][$zahod][$idcouple]=$inArr[$idcouple];				
			}
		}

foreach ($arrDance as $idDance => $dance){
echo '<h3>'. Html::encode($dance).'</h3>';	
$data=[];

for ($i=1; $i <= $turInfo->gettur('zahodcount'); $i++) {
	$data[$i]['heats']='Заход '.$i;
}


	foreach ($arr[$idDance] as $zahod => $value1) {
		if (count($value1)) {
				asort($value1);
				$data[$zahod]['heats']='Заход '.$zahod;
				$data[$zahod]['couple']=implode($value1, ', ');			
			}}
		
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