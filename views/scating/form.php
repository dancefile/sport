<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Оценки судей '.$tur['name'].' '.$tur['turname'];
//$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 
	asort($inArr);
    $columns[]=[
           	    'header' => 'Судьи/пары',
               	'attribute' => 'id',
               	
    	       ];
	foreach ($inArr as $nomer): 
   		$columns[]=[
           	    'header' => $nomer,
               	'attribute' => 'id'.$nomer,
               	'format' => 'raw',
               	
               	
    	       ];
	endforeach;
 
 
    $data=[];
	
    foreach ($judgesArr as $key => $judg): 
    	$data[$key] = ['id' => $judg];
			foreach ($inArr as $nomer){
			if (isset($krestArr[$key][$nomer])) {$value = $krestArr[$key][$nomer];$checked = TRUE;} else {$value = null;$checked = false;};
				if ($tur['typeSkating']==2) $data[$key]['id'.$nomer]=Html::checkbox ( 'bal;'.$key.';'.$nomer, $checked , $options = [] ); else 
					$data[$key]['id'.$nomer]=Html::textInput ( 'bal;'.$key.';'.$nomer, $value, $options = [] );	
			}
		
    endforeach;

    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => ['pageSize' => 10],

    ]);

?>
<?= Html::beginForm ( ['scating/entry', 'idT' => $idT, 'idD' => $idD, 'tS' => $tur['typeSkating']], 'post', [] ) ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
 
 ?>
<?= Html::submitButton('Submit', ['class' => 'submit']) ?>
<?= Html::endForm ( )?>
</div>