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
		$columns[0]['header']= $judg;//
		foreach ($coupels as $heatnumber => $couplesInHeat) {
			$data[$heatnumber]['id']='Заход '.$heatnumber;
			foreach ($couplesInHeat as $iCouple => $nomer) {
				if (isset($krestArr[$key][$nomer])) {$value = $krestArr[$key][$nomer];$checked = TRUE;} else {$value = null;$checked = false;};
				if ($tur['typeSkating']==2) $data[$heatnumber]['id'.$iCouple]=$nomer.' '.Html::checkbox ( 'bal;'.$key.';'.$nomer, $checked , $options = [] ); else 
					$data[$heatnumber]['id'.$iCouple]=$nomer.' '.Html::textInput ( 'bal;'.$key.';'.$nomer, $value, $options = [] );	
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