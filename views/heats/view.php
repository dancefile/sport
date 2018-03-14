<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;



// $turInfo->gettur('')
$this->title = $turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.nomer {
    font-size: 20px !important;;
}
</style>
<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 
 echo Html::a('Заходы для ведущего ', ['index','idT'=>$turInfo->getTur('idT'),'ved'=>'1'], ['class' => 'btn btn-success']);
 
    $columns=[[
           	    'header' => 'Номер',
               	'attribute' => 'nomer',
               	 'contentOptions' =>function ($model, $key, $index, $column){
                return ['class' => 'nomer'];
            },
    	       ],];

	foreach ($arrDance as $key => $dance){ 
   		$columns[]=[
           	    'header' => $dance,
               	'attribute' => 'id'.$key,
               	'format' => 'raw',
    	       ];
	};
        array_push($columns,
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
    	       ]); 

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
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
			filter: progid:DXImageTransform.Microsoft.Alpha(opacity=95);
			filter:alpha(opacity=95);
			z-index:999;
			position: absolute;
			top: 60px; left: 10px;
		}


   
    </style>	
<div id="search_advice_wrapper"><input id="setheats" type="text" value="s"/></div>
