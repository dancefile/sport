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
	foreach ($arrDance as $key => $dance): 
   		$columns[]=[
           	    'header' => $dance,
               	'attribute' => 'id'.$key,
               	
    	       ];
	endforeach;
 

    $data=[];
	$heatsArr=$turInfo->getHeats();
	$inArr=$turInfo->getIn();
	asort($inArr);
	 
    foreach ($inArr as $key => $nomer): 
    	$data[$key] = [	'nomer' => $nomer,
    					'name'=>$turInfo->GetCoupleName($key),
    					'club'=>$turInfo->GetCoupleName($key,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($key),
    					'Trener'=>$turInfo->GetCoupleTrener($key),
    					
    					];
		if (isset($heatsArr[$key])) {
			foreach ($heatsArr[$key] as $key1 => $value1) {
				$data[$key]['id'.$key1]=$value1;			
			}
		}
    endforeach;

    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
 echo Html::a('Создать новые заходы', ['new','idT'=>$turInfo->getTur('idT')], ['class' => 'btn btn-success']);
 ?>

</div>