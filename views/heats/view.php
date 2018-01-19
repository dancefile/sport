<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Заходы '.$tur['name'].' '.$tur['turname'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setings-index">

<h1><?= Html::encode($this->title) ?></h1>

<?php 

    $columns[]=[
           	    'header' => 'Пары/танцы',
               	'attribute' => 'id',
    	       ];
	foreach ($arrDance as $key => $dance): 
   		$columns[]=[
           	    'header' => $dance,
               	'attribute' => 'id'.$key,
               	
    	       ];
	endforeach;
 

    $data=[];
	asort($inArr);
	 
    foreach ($inArr as $key => $nomer): 
    	$data[$key] = ['id' => $nomer];
		if (isset($heatsArr[$key])) {
			foreach ($heatsArr[$key] as $key1 => $value1) {
				$data[$key]['id'.$key1]=$value1;			
			}
		}
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
    'columns' => $columns
]);
 echo Html::a('Создать новые заходы', ['new','idT'=>$idT], ['class' => 'btn btn-success']);
 ?>

</div>