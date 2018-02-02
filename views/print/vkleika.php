<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Вклейки '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<?php

	$inArr=$turInfo->getIn();

		
	//asort($inArr);
	  $columns=[
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
    	
		$data=[];
    	$key = array_search($nomer, $inArr);
    	$data[$nomer] = [
    					'name'=>$turInfo->GetCoupleName($key),
    					'club'=>$turInfo->GetCoupleName($key,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($key),
    					'Trener'=>$turInfo->GetCoupleTrener($key),
    					'place'=>$result['place'].' из '.$COUNTallCouple,
    					];
						
	
		    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo $Competition->name.' '.$Competition->data.' '.$Competition->place.'<br>'.
$turInfo->gettur('name').' '.$turInfo->gettur('turname')
;
echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);
	
	
	}
	
/*
	echo '<center>';
	foreach ($diploms as $diplom) {
		echo '<div class="startDiplom" style="height: 500px;"> </div>';
		echo '<div class="" style="height: 100px;">'.$diplom['name'].'</div>';
		echo '<div class="" style="height: 50px;">'.$diplom['place'].'</div>';
		echo '<div class="" style="height: 50px;">'.$Competition->shortname.'</div>';
		echo '<div class="" style="height: 50px;">'.$programname.'</div>';
		echo '<div class="" style="height: 50px;">'.$agename.'</div>';
		echo '<div class="" style="height: 50px;">'.$Competition->org.'<span style="width: 100px; display:inline-block;"></span>'.$Competition->chief.'</div>';
		echo '<div class="" style="height: 100px;"><img src="/img/signature.gif" /></div>';
		echo '<div class="" style="height: 50px;">'.$Competition->data.'</div>';
	} 
		
	</center>
	*/
?>
    					</div>
