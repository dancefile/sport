<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Балы '.$name;
//$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 

    $columns[]=[
           	    'header' => 'Судьи/танцы',
               	'attribute' => 'id0',
    	       ];
	foreach ($dancesArr as $key => $dance): 
   		$columns[]=[
           	    'header' => Html::a($dance, ['form','idD'=>$key,'idT'=>$idT], ['class' => 'btn btn-success']),
               	'attribute' => 'id'.$key,
               	
    	       ];
	endforeach;
 
 
    $data=[];
    foreach ($judgesArr as $key => $judg): 
    	$data[$key] = ['id0' => $judg];
		
		if (isset($krestArr[$key])) {
		//	var_dump($krestArr[$key]); echo '<p>';
		foreach ($krestArr[$key] as $key1 => $value1) {
			if (is_array($value1))
			foreach ($value1 as $key2 => $value2) {
				if (isset($data[$key]['id'.$key1])) $data[$key]['id'.$key1]++; else $data[$key]['id'.$key1]=1;
		//		echo $key.'][id'.$key1.'<br>';
				
			}
			
		}}
		//$krestArr[$row['judge_id']][$row['dance_id']][$row['in_id']]=$row['ball'];	
		
    endforeach;
	//var_dump($data);

   /* foreach ($Chess as $Ches):
    	$data[$Ches->judge_id] = array_merge($data[$Ches->judge_id],['s'.$Ches->category_id=>$Ches->nomer.(($Ches->chief) ? ' chief' : '')]);
    endforeach;*/ 
    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 10,
        	],

    ]);

?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]);
 echo Html::a('Посчет результата', ['calc','idT'=>$idT], ['class' => 'btn btn-success']);
 ?>

</div>