<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
// $turInfo->gettur('')
$this->title = 'Бегунки '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 

$heatsArr=$turInfo->getHeats();
	
$inArr=$turInfo->getIn();

$arrDance=$turInfo->getDances();
foreach ($arrDance as $keyDance => $dance){
	$arr[$keyDance][0]=$inArr;
}


		foreach ($heatsArr as $idcouple => $value1) {
			foreach ($value1 as $iddance => $zahod) {
				
				if ($iddance==0) {
				foreach ($arrDance as $keyDance => $dance){
					unset($arr[$keyDance][0][$idcouple]);
				$arr[$keyDance][$zahod][$idcouple]=$inArr[$idcouple];				
				}} else {
					unset($arr[$iddance][0][$idcouple]);
					$arr[$iddance][$zahod][$idcouple]=$inArr[$idcouple];
				}
				
				}
		}

    $columns=[[
           	    'header' => 'заход',
               	'attribute' => 'heats',
    	       ],
				];
			for ($i=1; $i <16 ; $i++) { 
	$columns[]=[
           	    'header' => $i,
               	'attribute' => 'c'.$i,
               	'format' => 'raw',
    	       ];			
			};
		   
foreach ($arrDance as $idDance => $dance){
$data=[];

for ($i=1; $i <= $turInfo->gettur('zahodcount'); $i++) {
	$data[$i]['heats']=$i;
	if ($prosmotr) $data['p'.$i]['heats']='просмотр';
	if ($pole) $data['s'.$i]['heats']=$polename;

}

	foreach ($arr[$idDance] as $zahod => $value1) {
		if (count($value1)) {
				asort($value1);
			$i=1;
			foreach ($value1 as $idcouple => $nomer) {
				$data[$zahod]['c'.$i]=$nomer;
				if ($pole) $data['s'.$zahod]['c'.$i]='';
				if ($prosmotr) $data['p'.$zahod]['c'.$i]='';
				$i++;
			}
		}
	}
    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);
foreach ($judge as $judgeId => $judgeName) {
	echo Html::encode($dance.' '.$judgeName);
	echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
}


}

 ?>

</div>