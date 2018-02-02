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
           	    'header' => 'Диплом',
               	'attribute' => 'diplom',
               	'format' => 'raw',
    	       ],
   			  [
           	    'header' => 'Балы',
               	'attribute' => 'bals',
               	'format' => 'raw',
    	       ]];
			   
$countDiploms=[1=>0,2=>0,3=>0];
	$diploms=[];
    foreach ($resultCouple as $nomer => $result){
    	$key = array_search($nomer, $inArr);
		$names=$turInfo->GetCoupleName($key);
		$diplom=['name'=>$names,'plase'=>$result['stepen']. ' степени. Баллов:'.$result['bal'] ];
		$diploms[]=$diplom;
		$countDiploms[$result['stepen']]++;		
		if (strripos($names,'<br>')!==false) {
		$diploms[]=$diplom;
		$countDiploms[$result['stepen']]++;		
		} 
		
    	$data[$nomer] = [	'nomer' => $nomer,
    					'name'=>$names,
    					'club'=>$turInfo->GetCoupleName($key,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($key),
    					'Trener'=>$turInfo->GetCoupleTrener($key),
    					'diplom'=>$result['stepen']. ' степени',
    					'bals'=>$result['bal'],
    					];
						
	}
	
	    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);
foreach ($countDiploms as $key => $value) {
echo 'Степень: '.$key.' кол: '.$value.'.<br>';	
}

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);
	echo '<center>';
	foreach ($diploms as $diplom) {
		echo '<div class="startDiplom" style="height: 500px;"> </div>';
		echo '<div class="" style="height: 100px;">'.$diplom['name'].'</div>';
		echo '<div class="" style="height: 50px;">'.$diplom['plase'].'</div>';
		echo '<div class="" style="height: 50px;">'.$Competition->shortname.'</div>';
		echo '<div class="" style="height: 50px;">'.$programname.'</div>';
		echo '<div class="" style="height: 50px;">'.$agename.'</div>';
		echo '<div class="" style="height: 50px;">'.$Competition->org.'<span style="width: 100px; display:inline-block;"></span>'.$Competition->chief.'</div>';
		echo '<div class="" style="height: 100px;"><img src="/img/signature.gif" /></div>';
		echo '<div class="" style="height: 50px;">'.$Competition->data.'</div>';
	} 
		
	
	
?></center>
    					</div>
