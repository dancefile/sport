<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Подсчет результатов '.$tur['name'].' '.$tur['turname'];
//$this->params['breadcrumbs'][] = ['label' => 'Список Отделений', 'url' => ['shaxmat']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">
<h1><?= Html::encode($this->title) ?></h1>

<?php 

    $columns[]=[
           	    'header' => 'пары',
               	'attribute' => 'id0',
    	       ];

   	$columns[]=[
           	    'header' => 'балы',
               	'attribute' => 'id1',
               	
    	       ];
	$columns[]=[
           	    'header' => 'Степень',
               	'attribute' => 'id2',
               	
    	       ];

 
 
    $data=[];
    
    foreach ($krestArr as $key => $krest): //заполняем строки таблицы и вычисляем проходной бал 
				$krest=ceil($krest * 100/$count)/100; 
	$text='3';  
	if ($krest>=3.5) {$text='2';}; 
	if ($krest>=4.5) {$text='1';};  
    	$data[] = ['id0' => $key,'id1' => $krest,'id2' => $text];
    endforeach;
	
	$broad=[];
	foreach ($data as $key => $krest): 
	 $broad[]=$key;	
	endforeach;		
	
	$provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 20,
        	],

    ]);

?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
    ]);
/*
if (count($broad)==1) {echo Html::a('Выводим '.$broad[0], ['krest','idT'=>$idT,'count'=>$broad[0]], ['class' => 'btn btn-success']);} 
else 
{
	$min=$broad[0]-1;
	$max=array_pop($broad);
	echo Html::a('Выводим '.$min, ['krest','idT'=>$idT,'count'=>$min], ['class' => 'btn btn-success']).' ';
	echo Html::a('Выводим '.$max, ['krest','idT'=>$idT,'count'=>$max], ['class' => 'btn btn-success']);
}

 */
 ?>

</div>