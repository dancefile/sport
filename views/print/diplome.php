<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Дипломы '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->request->post('programname')!==null) 
{
	$programname=Yii::$app->request->post('programname');
	$agename=Yii::$app->request->post('agename');
} else {

$turName=$turInfo->gettur('name');
$pos=stripos($turName,',');
if ($pos!==FALSE) {$programname=substr($turName, 0,$pos);$agename=substr($turName, $pos+1);}
else {$programname=$turName;$agename='';};
}

?>
<div class="site-about">
	<div  class="no-print">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::beginForm ( ['print/diplom', 'idT' => $turInfo->gettur('idT')], 'post', [] ) ?>
<p> Название программы:   <?= Html::textInput ( 'programname', $programname, $options = ['class' => 'judg'] );	?></p>
<p> Класс + возраст:   <?= Html::textInput ( 'agename', $agename, $options );	?></p>    
<?= Html::submitButton('Submit', ['class' => 'submit']) ?>
<?= Html::endForm ( )?>
<?php

	$inArr=$turInfo->getIn();

		
	//asort($inArr);
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
    	       ],
   			  [
           	    'header' => 'Место',
               	'attribute' => 'place',
               	'format' => 'raw',
    	       ]];
			   
	$diploms=[];
    foreach ($resultCouple as $nomer => $result){
    	$key = array_search($nomer, $inArr);
		$names=$turInfo->GetCoupleName($key);
		$diplom=['name'=>$names,'place'=>$result['place'] ];
		$diploms[]=$diplom;
		if (strripos($names,'<br>')!==false) {
		$diploms[]=$diplom;
		} 
		
    	$data[$nomer] = [	'nomer' => $nomer,
    					'name'=>$names,
    					'club'=>$turInfo->GetCoupleName($key,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($key),
    					'Trener'=>$turInfo->GetCoupleTrener($key),
    					'place'=>$result['place'],
    					];
						
	}
	
	    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);
echo '</div>';
echo '<div class="next-page"><h3>'.$turInfo->gettur('name').' '.$turInfo->gettur('turname').'</h3>';

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);
		echo '</div>';
	echo '<center>';
			end($diploms);
$lastKey=key($diploms);
?>
<style>
.diplom1{
    font-size: 42px !important;
}
.diplom2{
    font-size: 36px !important;
}
.diplom3{
    font-size: 32px !important;
}
.diplom4{
    font-size: 28px !important;
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
<?php
	foreach ($diploms as $key=>$diplom) {
			if ($lastKey==$key) echo '<div>'; else	echo '<div class="next-page">';
		echo '<div class="" style="height: 650px;"> </div>';
		echo '<div class="diplom1" style="height: 110px;">'.$diplom['name'].'</div>';
		echo '<div class="diplom2" style="height: 90px;">'.$diplom['place'].'</div>';
		echo '<div class="diplom2" style="height: 90px;">'.$Competition->shortname.'</div>';
		echo '<div class="diplom3" style="height: 90px;">'.$programname.'</div>';
		echo '<div class="diplom3" style="height: 175px;">'.$agename.'</div>';
		echo '<div class="diplom4" style="height: 75px;">'.$Competition->org.'<span style="width: 150px; display:inline-block;"></span>'.$Competition->chief.'</div>';
		echo '<div class="diplom4" style="height: 200px;"><img src="/img/signature.gif" /></div>';
		echo '<div class="diplom4" style="height: 50px;">'.$Competition->data.'</div>';
		echo '</div>';
	} 
		
	
	
?></center>
    					</div>
