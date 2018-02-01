<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Оценки судей заход '.$idZ.' '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
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



	<script>

window.onload=function(){
$('input:text:first').focus();

$('input:text').keypress(function(event){
	var b=event.which;
	var a=$(this);
	var c=$('input:text');
	var d=$(c).length;
	console.log($(a).attr('name'));
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
	


<?= Html::beginForm ( ['scating/entryallheats', 'idT' => $turInfo->gettur('idT'), 'idZ' => $idZ], 'post', [] ) ?>
<?php 
	
	
	$heatsArr=$turInfo->getHeats();
	$inArr=$turInfo->getIn();
	asort($inArr);//сортируем пары по номерам
$Dances=$turInfo->getDances();
//inArr[$row['id']]=$row['nomer'];
//heatsArr[$row['id_in']][$row['dance_id']]=$row['zahod'];	

 //$krestArr[$row['judge_id']][$row['dance_id']][$row['nomer']]=$row['ball'];	
	$danceCoupleArr=[];
	foreach ($inArr as $idCouple => $nomer) {
		foreach ($heatsArr[$idCouple] as $danceId => $zahod) {
			if ($zahod==$idZ) {
				
				if ($danceId!=0) $danceCoupleArr[$danceId][]=$nomer; else {
					foreach ($Dances as $key => $value) {
						$danceCoupleArr[$key][]=$nomer;
					}
				}
			
			
			
			}	
		}
		
	}
	
	//массив пар по танцем
	

	
	
	$maxColumns=0;//максимальное количество пар	в заходах	
 	foreach ($danceCoupleArr as $value) {
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

    
	asort($judge);//сортируем судей

	    foreach ($judge as $judgeId=> $judgeName){//обходим всех судей
    	$data=[];//обнуляем массив данных для таблицы	 
		$columns[0]['header']= $judgeName.' <spane id="judg'.$judgeId.'"></spane> ';//
		foreach ($danceCoupleArr as $danceId => $couplesInHeat) {
			$data[$danceId]['id']=$Dances[$danceId];
			foreach ($couplesInHeat as $iCouple => $nomer) {
				if (isset($krestArr[$judgeId][$danceId][$nomer])) {$value = $krestArr[$judgeId][$danceId][$nomer];} else {$value = null;};
					$data[$danceId]['id'.$iCouple]=$nomer.'<br>'.Html::textInput ( 'bal;'.$judgeId.';'.$danceId.';'.$nomer, $value, $options = ['class' => 'judg'.$judgeId] );	
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

