<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Оценки судей '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
//$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 


    $columns[]=[
           	    'header' => 'Судьи/Заходы',
               	'attribute' => 'id0',
    	       ];
			   
for ($zahod=1; $zahod <= $turInfo->gettur('zahodcount'); $zahod++) {
   		$columns[]=[
           	    'header' => Html::a('Заход '.$zahod, ['formallheats','idZ'=>$zahod,'idT'=>$turInfo->gettur('idT')], ['class' => 'btn btn-success']),
               	'attribute' => 'id'.$zahod,
               	
    	       ];
}
$heatsArr=$turInfo->getHeats();
$inArr=$turInfo->getIn();

//inArr[$row['id']]=$row['nomer'];
//heatsArr[$row['id_in']][$row['dance_id']]=$row['zahod'];	

 //$krestArr[$row['judge_id']][$row['dance_id']][$row['nomer']]=$row['ball'];	
 
 $data=[]; 
 foreach ($judge as $judgId => $judgename){
	 $data[$judgId] = ['id0' => $judgename];   	
	if (isset($krestArr[$judgId])) {
		foreach ($krestArr[$judgId] as $dance_id => $value1) {
			
		if (is_array($value1)) 	
		foreach ($value1 as $nomer => $ball) {
		$key = array_search($nomer, $inArr);
		if (isset($heatsArr[$key][$dance_id]))	var_dump($heatsArr[$key][$dance_id]); echo '<p>';	
		if ($key!==FALSE) {$zahod=-1;
			if (isset($heatsArr[$key][0])) $zahod=$heatsArr[$key][0]; else
		if (isset($heatsArr[$key][$dance_id])) $zahod=$heatsArr[$key][$dance_id];
			if ($zahod!=-1)if (isset($data[$judgId]['id'.$zahod])) $data[$judgId]['id'.$zahod]++; else $data[$judgId]['id'.$zahod]=1;
		}	}}
	}		
			
   }
	


    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 50,
        	],

    ]);

?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
    'summary' => false,
    ]);

 echo Html::a('Посчет результата', ['calc','idT'=>$turInfo->gettur('idT')], ['class' => 'btn btn-success']);
 ?>

</div>