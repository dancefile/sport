<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
// $turInfo->gettur('')
$this->title = 'Бегунки '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.begunok{
    font-size: 22px !important;

    
}
.nomer1 {
	margin: 0px;
    font-size: 20px !important;
    text-align: center;
}
.nomer {
	margin: 0px;
    font-size: 30px !important;
    text-align: center;
}
.otstup{
	padding-bottom: 10px;
}
</style>
<div class="setings-index">

<h1 class="no-print"><?= Html::encode($this->title) ?></h1>

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
               	'headerOptions' => ['class' =>'no-print','style' => ''],
               	'contentOptions' => ['class' =>'nomer1'],
    	       ],
				];
			for ($i=1; $i <16 ; $i++) { 
	$columns[]=[
           	    'header' => $i,
               	'attribute' => 'c'.$i,
               	'format' => 'raw',
               	'headerOptions' => ['class' =>'no-print','style' => ''],
               	'contentOptions' => ['class' =>'nomer'],
               	'options' => ['style' => 'width: 55px; max-width: 55px;'],
    	       ];			
			};
		   
for ($zahod=1; $zahod <= $turInfo->gettur('zahodcount'); $zahod++) {
	
if ($zahod < $turInfo->gettur('zahodcount')) echo '<div class="next-page">'; else	 echo '<div>';	
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
	echo '<div class="not-razriv otstup">';
	echo '<h3>'.Html::encode($turInfo->gettur('id').'. '.$turInfo->gettur('name').' '.$turInfo->gettur('turname')).'</h3>';
	echo '<div class="begunok">'.Html::encode('заход '.$zahod).'<span style="width: 100px; display:inline-block;"> </span>'.Html::encode($judgeName.' ______________');
	echo '<span style="width: 100px; display:inline-block;"> </span>';
	echo '</div>';
	echo '<div class="">'.Html::encode($Competition->name.' '.$Competition->data).'</div>';
	echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
	]);
	echo '</div>';
}

echo '</div>';
}

 ?>

</div>