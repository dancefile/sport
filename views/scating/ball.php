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
    
    foreach ($sumArr as $key => $krest): //заполняем строки таблицы и вычисляем проходной бал 
    	$data[] = ['id0' => $key,'id1' => $krest,'id2' => $stepeni[$key]];
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

 ?>

</div>