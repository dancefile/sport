<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Балы '.$name.' '.$dance['name'];
//$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 

    $columns[]=[
           	    'header' => 'Судьи/пары',
               	'attribute' => 'id0',
               	
    	       ];
	foreach ($inArr as $key => $nomer): 
   		$columns[]=[
           	    'header' => $nomer,
               	'attribute' => 'id'.$key,
               	'format' => 'raw',
               	
               	
    	       ];
	endforeach;
 
 
    $data=[];
	
    foreach ($judgesArr as $key => $judg): 
    	$data[$key] = ['id0' => $judg];
			foreach ($inArr as $key2 => $nomer){
			if (isset($krestArr[$key][$key2])) {$value = $krestArr[$key][$key2];$checked = TRUE;} else {$value = null;$checked = false;};
				if ($typeSkating==2) $data[$key]['id'.$key2]=Html::checkbox ( 'bal;'.$key.';'.$key2, $checked , $options = [] ); else 
					$data[$key]['id'.$key2]=Html::textInput ( 'bal;'.$key.';'.$key2, $value, $options = [] );	
			}
		
    endforeach;

    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => ['pageSize' => 10],

    ]);

?>
<?= Html::beginForm ( ['scating/entry', 'idT' => $idT, 'idD' => $idD, 'tS' => $typeSkating], 'post', [] ) ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
 
 ?>
<?= Html::submitButton('Submit', ['class' => 'submit']) ?>
<?= Html::endForm ( )?>
</div>