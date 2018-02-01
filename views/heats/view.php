<?php

/* @var $this yii\web\View */

use kartik\grid\EditableColumnAction;
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
 echo Html::a('Заходы для ведущего ', ['index','idT'=>$turInfo->getTur('idT'),'ved'=>'1'], ['class' => 'btn btn-success']);
 
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
   				'editableOptions'=> ['formOptions' => ['action' => ['/site/editbook']]],
           	    'header' => $dance,
               	'attribute' => 'id'.$key,
               	
               	//'value' => function($model, $key, $index, $grid) {
               		//var_dump($grid);
       // return $index;
      //}
               	
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
    'columns' => $columns,

]);//'new','idT'=>$turInfo->getTur('idT')
 echo Html::a('Создать новые заходы', ['','idT'=>$turInfo->getTur('idT')], ['class' => 'greatGeats btn btn-success']);
 ?>

</div>

	<script>

window.onload=function(){
	
$( ".greatGeats" ).click(function() {
  
$.get( "<?='/heats/new?idT='.$turInfo->getTur('idT') ?>", function( ) {

 location.reload();

});
  
  
  return false;
});
}
</script>

