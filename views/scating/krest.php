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
 $columns[]=['class' => 'yii\grid\SerialColumn'];
    $columns[]=[
           	    'header' => 'пары',
               	'attribute' => 'id0',
    	       ];

   		$columns[]=[
           	    'header' => 'кресты',
               	'attribute' => 'id1',
               	
    	       ];

 
 
    $data=[];
    $i=1;
	$GLOBALS['prohodBal']=0;
    
    foreach ($krestArr as $key => $krest): //заполняем строки таблицы и вычисляем проходной бал 
    	$data[$i] = ['id0' => $inArr[$key],'id1' => $krest];
		if ($ParNextTur==$i) {$GLOBALS['prohodBal']=$data[$i]['id1'];}
		$i++;
    endforeach;
	
	$broad=[];
	foreach ($data as $key => $krest): 
	 if ($krest['id1']==$GLOBALS['prohodBal']) {
	 $broad[]=$key;	
	 }
	endforeach;		
	
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
    'columns' => $columns,
     'rowOptions' => function ($model, $index, $widget, $grid) {

                          if ($model['id1'] == $GLOBALS['prohodBal']) {
                                return ['class' => 'not-set'];
                            } else {
                                return [];
                            }
                         },
]);

if (count($broad)==1) {echo Html::a('Выводим '.$broad[0], ['krestgo','idT'=>$idT,'count'=>$broad[0]], ['class' => 'btn btn-success']);} 
else 
{
	$min=$broad[0]-1;
	$max=array_pop($broad);
	echo Html::a('Выводим '.$min, ['krest','idT'=>$idT,'count'=>$min], ['class' => 'btn btn-success']).' ';
	echo Html::a('Выводим '.$max, ['krest','idT'=>$idT,'count'=>$max], ['class' => 'btn btn-success']);
}

 
 ?>

</div>