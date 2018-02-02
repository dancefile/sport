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
           	    'header' => $dance,
               	'attribute' => 'id'.$key,
               	'format' => 'raw',

               	
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
						foreach ($arrDance as $key1 => $dance) {
		if (isset($heatsArr[$key][$key1])) {
		//	foreach ($heatsArr[$key] as $key1 => $value1) {
				$data[$key]['id'.$key1]=Html::a($heatsArr[$key][$key1],NULL, ['class' => 'setheats btn btn-success','id' =>$nomer.'_'.$key1]);			
			//}
		} else $data[$key]['id'.$key1]=Html::a('+',NULL, ['class' => 'setheats btn btn-success','id' =>$nomer.'_'.$key1]);
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
	
	$('html').click(function(){
		$('#search_advice_wrapper').hide();
	});
		$('#setheats').click(function(){
		return false;
	});
	
$( ".setheats" ).click(function() {
loc=$(this).offset();
$("#setheats").val($(this).html());
$("#setheats").attr('name',$(this).attr('id'));
$('#search_advice_wrapper').show().offset({top:loc.top, left:loc.left});
$("#setheats").select();
  return false;
});

	$("#setheats").keyup(function(I){
		//alert('data');
		// определяем какие действия нужно делать при нажатии на клавиатуру
		switch(I.keyCode) {
			// игнорируем нажатия на эти клавишы
			case 13:  // enter
			$.get( "<?='/heats/new1?idT='.$turInfo->getTur('idT') ?>&name="+$(this).attr('name')+"&value="+$(this).val(), function( ) {$('#search_advice_wrapper').hide();});
			$('#'+$(this).attr('name')).html($(this).val());
}
});
}
</script>
<style>

		#search_advice_wrapper{
			display:none;
			width: 100px;
			height: 25px;
			background-color: rgb(80, 80, 80);
			-moz-opacity: 0.95;
			opacity: 0.95;
			-ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=95);
			filter: progid:DXImageTransform.Microsoft.Alpha(opacity=95);
			filter:alpha(opacity=95);
			z-index:999;
			position: absolute;
			top: 60px; left: 10px;
		}


   
    </style>	
<div id="search_advice_wrapper"><input id="setheats" type="text" value="s"/></div>
