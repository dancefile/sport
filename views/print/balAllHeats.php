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
           	    'header' => 'танец',
               	'attribute' => 'dance',
    	       ],
				];
			for ($i=1; $i <16 ; $i++) { 
	$columns[]=[
           	    'header' => $i,
               	'attribute' => 'c'.$i,
               	'format' => 'raw',
    	       ];			
			};
		   
for ($zahod=1; $zahod <= $turInfo->gettur('zahodcount'); $zahod++) {
$data=[];
foreach ($arrDance as $idDance => $dance){

	$data[$idDance]['dance']=$dance;
	if ($prosmotr) $data['p'.$idDance]['dance']='просмотр';
	if ($pole) $data['s'.$idDance]['dance']=$polename;

}

foreach ($arr as $iddance => $value1) {

		if (count($value1[$zahod])) {
				asort($value1[$zahod]);
			$i=1;
			//var_dump($value1[$zahod]);
			foreach ($value1[$zahod] as $idcouple => $nomer) {
				$data[$iddance]['c'.$i]=$nomer;
				if ($pole) $data['s'.$iddance]['c'.$i]='';
				if ($prosmotr) $data['p'.$iddance]['c'.$i]='';
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
	echo Html::encode('заход '.$zahod.'. '.$judgeName);
	echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
}


}

 ?>

</div>