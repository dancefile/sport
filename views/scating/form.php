<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Оценки судей '.$dance['name'].' '.$tur['name'].' '.$tur['turname'];
//$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<style>
input[type="checkbox"] {   
  width: 18px;
  height: 18px;
  padding: 0;
  margin:0;
  vertical-align: bottom;
  position: relative;
  top: -1px;
  *overflow: hidden; }
  
input[type="checkbox"]:focus {
  background: red;
    outline:3px solid red;
  }
  
input[type="text"] { 
width: 25px;
}	
input[type="text"]:focus {
     outline:3px solid red;
  }
  
.green {
	color: green;
}  

.red {
	color: red;
}
</style>


<? switch ($tur['typeSkating']) {
	case '1': ?>
	<script>

window.onload=function(){
$('input:text:first').focus();

$('input:text').keypress(function(event){
	var b=event.which;
	var a=$(this);
	var c=$('input:text');
	var d=$(c).length;
	$(c).each(function(i,elem) {
    	if ($(a).attr('name')==$(elem).attr('name')) {
			if ((b>48) && (b<58)) {
				var k=i+1;
				$(a).val(String.fromCharCode(b));
				if (d>k) $('input:text:eq('+k+')').focus(); else $('button:submit:first').focus();	
			}
		}
	});	
return false;
})
.contextmenu(function(event){return false;});
}
</script>
	
<?	
	break;
	case '2':
?>
<script>
window.onload=function(){

$('input:checkbox:first').focus();
$('input:checkbox').keypress(function(event){
	var b=event.which;
	var a=$(this);
	var c=$('input:checkbox');
	var d=c.length;
	$(c).each(function(i,elem) {
    	if ($(a).attr('name')==$(elem).attr('name')) {
    		var k=i+1;
			if (b==49) $(a).attr( "checked",true ); else $(a).attr( "checked",false ); 
			if (d>k) $('input:checkbox:eq('+k+')').focus(); else $('button:submit:first').focus();
			countkrest();
			return false; 
		};
	});
})
.contextmenu(function(event){return false;})
.change(function(){
	countkrest();
});

countkrest();
};//window.onload

var ParNextTur = <?=$tur['ParNextTur'] ?>;
var judges = ["<?=implode('","',array_keys($judgesArr)) ?>"];

function countkrest () {
  judges.forEach(function(item) {
  	var countkrest=$('.judg'+item+':checked').length;
  	$('#judg'+item).html(countkrest);
  	if (countkrest==ParNextTur) {$('#judg'+item).addClass('green').removeClass('red');} else {$('#judg'+item).addClass('red').removeClass('green');} 
  	
});
}

</script>
<?		
		break;
	
	case '3': ?>
<script>
window.onload=function(){
$('input:text:first').focus();

$('input:text').keypress(function(event){
	var b=event.which;
	var a=$(this);
	var c=$('input:text');
	var d=$(c).length;
	$(c).each(function(i,elem) {
    	if ($(a).attr('name')==$(elem).attr('name')) {
			if ((b>48) && (b<58)) {
				var k=i+1;
				$(a).val(String.fromCharCode(b));
				if (d>k) $('input:text:eq('+k+')').focus(); else $('button:submit:first').focus();	
				countkrest();
			}
		}
	});	
return false;
})
.contextmenu(function(event){return false;})
.change(function(){
	countkrest();
});
countkrest();
}

function countkrest () {
  judges.forEach(function(item) {
  	var a=$('.judg'+item+'');
  	var countkrest=$(a).length;
  	var place = [];
	var error=false;
	$('#judg'+item).removeClass('green red').html('');
  	$(a).each(function(i,elem) {
  		if(!error) {
  		var b=parseInt($(elem).val(), 10);
  		if (b>0 && b<countkrest+1) {
  			if (place.indexOf(b)==-1) {place.push(b); 
  			} else {$('#judg'+item).addClass('red').html('ошибка'); error=true;};
  		} else {error=true;};
  		}  
  	});
  	if (place.length==countkrest && !error) {$('#judg'+item).addClass('green').html('ок');};
	});
}
var judges = ["<?=implode('","',array_keys($judgesArr)) ?>"];
</script>
		
<?		break;
} ?>

<?= Html::beginForm ( ['scating/entry', 'idT' => $idT, 'idD' => $idD, 'tS' => $tur['typeSkating']], 'post', [] ) ?>
<?php 
	
	
	
	asort($inArr);//сортируем пары по номерам

    $coupels=array_fill (1, $tur['zahodcount'], [] );//массив пар по заходам, если у пары не задан заход то присваиваем ей 0 заход
	foreach ($inArr as $id => $nomer) {
		if (isset($heatsArr[$id])) {$coupels[$heatsArr[$id]][]=$nomer; } else {$coupels[0][]=$nomer;}
	};
		
	$maxColumns=0;//максимальное количество пар	в заходах	
 	foreach ($coupels as $value) {
 		if (count($value)>$maxColumns) $maxColumns=count($value);
	};	
	
	$columns[0]=[//задаем 1 колонку таблиц, в дальнейшем будем менять название этой колонки
           	    'header' => '&nbsp;',
               	'attribute' => 'id',
               	'options' => ['style' => 'width: 100px; max-width: 100px;'],
				'contentOptions' => ['style' => 'width: 100px; max-width: 100px;'], 
				'headerOptions' => ['colspan' => $maxColumns+1]
    	       ];
	for ($i=0; $i < $maxColumns; $i++) {//доформировываем массив колонок к таблиц 
	$columns[$i+1]=[
           	    'header' => '&nbsp;',
               	'attribute' => 'id'.$i,
               	'format' => 'raw',
               	'headerOptions' => [
    								'style' => 'display: none;',
									]
    	       ];
	}

    
	asort($judgesArr);//сортируем судей
    foreach ($judgesArr as $key => $judg){//обходим всех судей
    	$data=[];//обнуляем массив данных для таблицы	 
		$columns[0]['header']= $judg.' <spane id="judg'.$key.'"></spane> ';//
		foreach ($coupels as $heatnumber => $couplesInHeat) {
			$data[$heatnumber]['id']='Заход '.$heatnumber;
			foreach ($couplesInHeat as $iCouple => $nomer) {
				if (isset($krestArr[$key][$nomer])) {$value = $krestArr[$key][$nomer];$checked = TRUE;} else {$value = null;$checked = false;};
				if ($tur['typeSkating']==2) $data[$heatnumber]['id'.$iCouple]=$nomer.' '.Html::checkbox ( 'bal;'.$key.';'.$nomer, $checked , $options = ['class' => 'judg'.$key] ); else 
					$data[$heatnumber]['id'.$iCouple]=$nomer.'<br>'.Html::textInput ( 'bal;'.$key.';'.$nomer, $value, $options = ['class' => 'judg'.$key] );	
				;
			}
		}
		
		

		
		
		
		$provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => ['pageSize' => 1000],
    	]);
		
		echo GridView::widget([
    							'dataProvider' => $provider,
    							'columns' => $columns,
    							'summary'=>'' 
							]);
    
	};



?>

 
 
<?= Html::submitButton('Submit', ['class' => 'submit']) ?>
<?= Html::endForm ( )?>
</div>

