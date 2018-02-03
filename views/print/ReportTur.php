<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Итоги '.$turInfo->gettur('name').' '.$turInfo->gettur('turname');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<?php

//Html::tag('p', Html::encode($user->name), ['class' => 'username']) 
echo  Html::tag('h3', Html::encode($Competition->name));
echo  Html::tag('h4', Html::encode($turInfo->gettur('name').' '.$turInfo->gettur('turname')));
echo  Html::tag('h4', Html::encode($Competition->place.' '.$Competition->data));

	$inArr=$turInfo->getIn();

		
	//asort($inArr);
	  $columns=[
			  [
           	    'header' => 'Судейская бригада',
               	'attribute' => 'name',
               	'format' => 'raw',
    	       ]];
		$data=[];
			   
$judgeCount=count($judgeName);
    foreach ($judgeName as $nomer => $name){
    	$data[$nomer] = ['name'=>$name];
						
	}
	
	    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);
	

$inArr=$turInfo->getIn();
	
	  $columns=[[
           	    'header' => 'Номер',
               	'attribute' => 'nomer',
    	       ],
			  [
           	    'header' => 'Участники',
               	'attribute' => 'name',
               	'format' => 'raw',
    	       ],
    	       			  [
           	    'header' => 'Клуб',
               	'attribute' => 'club',
               	'format' => 'raw',
    	       ],
   			  [
           	    'header' => 'Город',
               	'attribute' => 'City',
               	'format' => 'raw',
    	       ],
   			  [
           	    'header' => 'Тренеры',
               	'attribute' => 'Trener',
               	'format' => 'raw',
    	       ],
  ];
			 $data=[];  
			
			//var_dump($inArr);
			 
		  foreach ($inArr as $coupleid => $nomer){
		  	    		
		  	    	$data[$coupleid] = [	'nomer' => $nomer,
    					'name'=>$turInfo->GetCoupleName($coupleid),
    					'club'=>$turInfo->GetCoupleName($coupleid,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($coupleid),
    					'Trener'=>$turInfo->GetCoupleTrener($coupleid),
    					];
			
		  }	 
			 
		    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);	
	
 $data=[]; 	
 
 
 
	 $columns=[];	
	 
	 
	 
	 
	 
	 
	 
	 
	 switch ($turInfo->gettur('typeSkating')) {
			case '1'://подсчет балов
			
			$columns=[[
           	    'header' => '№',
               	'attribute' => 'nomer',
    	       ],
			  [
           	    'header' => 'Диплом',
               	'attribute' => 'diplom',
               	'format' => 'raw',
    	       ],
    	       			  [
           	    'header' => 'Сумма',
               	'attribute' => 'sum',
               	'format' => 'raw',
    	       ],
   			 
  			];
			$dancesArr = array_fill_keys(explode(',',str_replace(' ','',$turInfo->gettur('dances'))), '');

			
			;
			
			foreach ($turInfo->getDances() as $key => $value) {$columns[]=[
           	    'header' => $value,
               	'attribute' => 'd'.$key,
    	       ];	}

				 foreach ($resultsArr as $nomer => $result) {
				 	 $data[$nomer]=['nomer' => $nomer,
				 	 				'diplom' =>$result['place'].' степени',
				 	 				'sum' =>$result['result']];
					foreach ($turInfo->getDances() as $keyDance => $valueDance) {
						$arr=array_fill ( 1 , $judgeCount , '-' );
						if (isset($krestArr[$nomer][$keyDance]))
						foreach ($krestArr[$nomer][$keyDance] as $key => $value) {
							$arr[$key]=$value;
						}
						$data[$nomer]['d'.$keyDance]=implode($arr);
						
					}
				 }
			break;
				
			case '2'://подсчет крестов
			
						$columns=[[
           	    'header' => '№',
               	'attribute' => 'nomer',
    	       ],
			  [
           	    'header' => 'место',
               	'attribute' => 'place',
               	'format' => 'raw',
    	       ],
    	       			  [
           	    'header' => 'сумма',
               	'attribute' => 'sum',
               	'format' => 'raw',
    	       ],
   			 
  			];
			$dancesArr = array_fill_keys(explode(',',str_replace(' ','',$turInfo->gettur('dances'))), '');
			
			
						foreach ($turInfo->getDances() as $key => $value) {$columns[]=[
           	    'header' => $value,
               	'attribute' => 'd'.$key,
    	       ];	}
				$razdel=false;		
				foreach ($resultsArr as $nomer => $result) {
				 	if (!$razdel && !$result['nextTur']) {$razdel=true; $data[]=[];}
					
					$data[$nomer]=['nomer' => $nomer,
				 	 				'place' =>$result['place'],
				 	 				'sum' =>$result['result']];
					
				foreach ($turInfo->getDances() as $keyDance => $valueDance) {
						$arr=array_fill ( 1 , $judgeCount , '-' );
						if (isset($krestArr[$nomer][$keyDance]))
						foreach ($krestArr[$nomer][$keyDance] as $key => $value) {
							$arr[$key]='x';
						}
						$data[$nomer]['d'.$keyDance]=implode($arr);
						
					}
				 }
				
			break;
			
			case '3'://скайтинг
			 	
 
 
 
	$columns=[[
           	    'header' => '№',
               	'attribute' => 'nomer',
    	       ],
			  [
           	    'header' => 'Судейские оценки',
               	'attribute' => 'ball',
               	'format' => 'raw',
    	       ],
    	       			  [
           	    'header' => 'Место',
               	'attribute' => 'place',
               	'format' => 'raw',
    	       ],
   			 
  			];	
			
			foreach ($turInfo->getDances() as $key => $value) {
			echo  Html::tag('h4', Html::encode($value));
				$data=[]; 
								$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $turInfo->gettur('idT'),'dance_id'=>$key])
					->orderBy(['nomer' => SORT_ASC]);
				foreach ($results->each() as $result) {
					 $nomer=$result['nomer'];
					if (isset($sum[$nomer])) {$sum[$nomer]=$sum[$nomer]+$result['place'];} else $sum[$nomer]=$result['place'];
					$str='';
					foreach ($judge as $jId => $jNomer) {
					$str.=$krestArr[$nomer][$key][$jNomer];	
					}
					$data[$nomer]=['nomer' => $nomer,'ball' =>$str,'place' =>$result['place']];
					
				}
				
				
					    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);	
			
				
				
				
			}
			
			
				$columns=[[
           	    'header' => '№',
               	'attribute' => 'nomer',
    	       ],
			  [
           	    'header' => 'Сумма мест',
               	'attribute' => 'sum',
               	'format' => 'raw',
    	       ],
    	       			  [
           	    'header' => 'Итог',
               	'attribute' => 'place',
               	'format' => 'raw',
    	       ],
   			 
  			];
			$data=[]; 
				foreach ($resultsArr as $nomer => $result) {
						$data[$nomer]=['nomer' => $nomer,
				 	 				'sum' =>$sum[$nomer],
				 	 				'place' =>$result['place']];
				}
				
				
							    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns,
	
	]);	
			break;
			
				
		 }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	    

	
?>
    					</div>
