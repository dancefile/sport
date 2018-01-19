<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\Scating;
use app\models\Otd;

class ScatingController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	
	public function actionKrest($idT=0,$count=0) //подсчет результатов тура
	{
	
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['category_id','name','typeSkating','ParNextTur','nomer'])
	    ->from('tur')
	    ->where(['id' => $idT])
		->one();
		
		if (!isset($tur["typeSkating"])) return $this->error('Не наден тур или не задан способ подсчета результатов');	
		
		$category = (new \yii\db\Query()) //получаем название категории данного тура
	    ->select(['name'])
	    ->from('category')
	    ->where(['id' => $tur["category_id"]])
		->one();
		
		if (!isset($category['name'])) return $this->error('Не найдена категория');
	
		$nexttur = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['id','name','nomer'])
	    ->from('tur')
	    ->where(['category_id' => $tur['category_id']])
		->andWhere(['>', 'nomer', $tur['nomer']])
		->orderBy(['nomer' => SORT_ASC])
		->one();	
	
		if (!isset($nexttur['id'])) return $this->error('Не найден следующий тур');	
		
		$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    	->select(['dance_id','in_id','ball'])
    	->from('krest')
    	->where(['tur_id' => $idT]);	
		
		$krestArr=[];
		
		foreach ($krest->each() as $row) {
			if (isset($krestArr[$row['in_id']])) $krestArr[$row['in_id']]++;
			else $krestArr[$row['in_id']]=1;
		}
	
		$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    	->select(['couple_id','nomer','who'])
    	->from('in')
    	->where(['tur_id' => $idT]);	
		
		foreach ($in->each() as $row) {
			$inArr[$row['couple_id']]=$row['who'];	
		}	

		$innext = (new \yii\db\Query()) //получаем список пар  за текущей тур
    	->select(['id','couple_id','nomer','who'])
    	->from('in')
    	->where(['tur_id' => $nexttur['id']]);
		$delIn=[];
		foreach ($innext->each() as $row) {
		 if (isset($inArr[$row['couple_id']]) && $inArr[$row['couple_id']]==$row['who']) {$delIn[]=$row['id'];}	
		}		

		if (count($delIn)) Yii::$app->db->createCommand()->delete('in', ['in','id',$delIn])->execute();

		arsort($krestArr);
		var_dump($krestArr);
		//Yii::$app->db->createCommand()->batchInsert('in', ['judge_id', 'tur_id', 'dance_id', 'in_id', 'ball'], $insetArr)->execute();
		

				
		
		
		
//return $this->error('-');	
	}
    private function error($message) //вывод критических ошибок
	{
		return $this->render('about', ['message' => '<pre> Ошибка! ' .$message. '</pre>']);	
	}//error

	public function actionCalc($idT=0) //подсчет результатов тура
	{
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['category_id','name','typeSkating','ParNextTur','nomer'])
	    ->from('tur')
	    ->where(['id' => $idT])
		->one();
		
		if (!isset($tur["typeSkating"])) return $this->error('Не найден тур или не задан способ подсчета результатов');	
		
		$category = (new \yii\db\Query()) //получаем название категории данного тура
	    ->select(['name'])
	    ->from('category')
	    ->where(['id' => $tur["category_id"]])
		->one();
		
		if (!isset($category['name'])) return $this->error('Не найдена категория');	
	

		switch ($tur["typeSkating"]) { //подсчет результатов тура в зависимости от способа подсчета
			case '2'://подсчет крестов
				$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','in_id','ball'])
    			->from('krest')
    			->where(['tur_id' => $idT]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($krestArr[$row['in_id']])) $krestArr[$row['in_id']]++;
					else $krestArr[$row['in_id']]=1;
				}
	
				$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    			->select(['couple_id','nomer'])
    			->from('in')
    			->where(['tur_id' => $idT]);	
		
				foreach ($in->each() as $row) {
					$inArr[$row['couple_id']]=$row['nomer'];	
				}	
				
				arsort($krestArr);
				
				return $this->render('krest', [
								'ParNextTur' => $tur['ParNextTur'],
								'inArr' => $inArr,
								'krestArr' => $krestArr,
								'name' => $tur['name'].' '.$category['name'],
								'idT' => $idT]);		
			break;
			
			default:
				$this->error('не задан способ подсчета результатов');	
				break;
		}

	}//actionCalc



	public function actionForm($idT=0,$idD=0) //ввод оченок судей парам за танец
	{
		$tur = (new \yii\db\Query()) //получаем номер категории данного тура
	    ->select(['category_id','name','typeSkating'])
	    ->from('tur')
	    ->where(['id' => $idT])
		->one();
	
	
		if (!isset($tur["category_id"])) return $this->error('Не найден тур');		
	
	
		$category = (new \yii\db\Query()) //получаем название категории данного тура
	    ->select(['name'])
	    ->from('category')
	    ->where(['id' => $tur["category_id"]])
		->one();
		
		if (!isset($category['name'])) return $this->error('Не найдена категория');	
	
	
		
		$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $tur['category_id']])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
	
		foreach ($judges->each() as $row) {
			$judgesArr[$row['id']]=$row['sname'].' '.$row['name']; 
		}
	
		$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей танец за текущей тур
    	->select(['judge_id','dance_id','in_id','ball'])
    	->from('krest')
    	->where(['tur_id' => $idT, 'dance_id' => $idD]);	
		
		$krestArr=[];
		foreach ($krest->each() as $row) {
			$krestArr[$row['judge_id']][$row['in_id']]=$row['ball'];	
		}
	
		$in = (new \yii\db\Query()) //получаем список пар в текущем танеце за текущей тур
    	->select(['couple_id','nomer'])
    	->from('in')
    	->where(['tur_id' => $idT]);	
		
		foreach ($in->each() as $row) {
			$inArr[$row['couple_id']]=$row['nomer'];	
		}
		
		$dance = (new \yii\db\Query()) //получаем имя текущего танца тура
    	->select(['name','id'])
    	->from('dance')
    	->where(['id' => $idD])
		->one();
		
	return $this->render('form', ['inArr' => $inArr,
								 'krestArr' => $krestArr,
								 'judgesArr' => $judgesArr,
								 'typeSkating'=>$tur['typeSkating'], 
								 'name' => $tur['name'].' '.$category['name'],
								 'dance' => $dance,
								 'idT' => $idT,
								 'idD' => $idD]);		
		
	}//actionForm

	
	public function actionEntry($idT=0, $idD=0, $tS=0) //сохраняем оценки
    {
    	$insetArr=[];
    	foreach (Yii::$app->request->post() as $key => $value) {
    		$keyar=explode(';', $key);
			if ($keyar[0]=='bal') {
				if (trim($value)) {
					$insetArr[]=[$keyar[1], $idT, $idD, $keyar[2], $value];
					//echo $key.' => '.$value.'<br>';
				}
				
			};
			
		}
		
		Yii::$app->db->createCommand()->delete('krest', 'tur_id = :idT AND dance_id = :idD ',[':idT' => $idT, ':idD'=>$idD])->execute();
		
		Yii::$app->db->createCommand()->batchInsert('krest', ['judge_id', 'tur_id', 'dance_id', 'in_id', 'ball'], $insetArr)->execute();
	//var_dump(Yii::$app->request->post());
	return self::actionInput($idT);
	}//actionEntry
	
	
	public function actionInput($id=0) //ввывод количестава оценок судей за каждый танец
	{
		$tur = (new \yii\db\Query()) //получаем информацию о данном туре
	    ->select(['category_id','dances','name'])
	    ->from('tur')
	    ->where(['id' => $id])
		->one();
	
		if (!isset($tur["category_id"])) return $this->error('Не наден тур');
	
		$category = (new \yii\db\Query()) //получаем название категории данного тура
	    ->select(['name'])
	    ->from('category')
	    ->where(['id' => $tur["category_id"]])
		->one();
		
		if (!isset($category['name'])) return $this->error('Не надена категория');	
	
		$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $tur['category_id']])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
	
		foreach ($judges->each() as $row) {
			$judgesArr[$row['id']]=$row['sname'].' '.$row['name']; 
		}
	
		$krest = (new \yii\db\Query()) //получаем оценки всех судей за все танцы за текущей тур
    	->select(['judge_id','dance_id','in_id','ball'])
    	->from('krest')
    	->where(['tur_id' => $id]);	
		
		$krestArr=[];
		foreach ($krest->each() as $row) {
			$krestArr[$row['judge_id']][$row['dance_id']][$row['in_id']]=$row['ball'];	
		}
	
		$danceid=explode(",",str_replace(' ','',$tur['dances']));
	
		$dances = (new \yii\db\Query()) //получаем имя и id танцев тура
    	->select(['name','id'])
    	->from('dance')
    	->where(['id' => $danceid]);	
		
		foreach ($dances->each() as $row) {
			$dancesArr[$row['id']]=$row['name'];	
		}
	
	return $this->render('list', ['dancesArr' => $dancesArr, 'krestArr' => $krestArr, 'judgesArr' => $judgesArr, 'name' => $tur['name'].' '.$category['name'], 'idT' => $id]);	
	} //actionInput

	public function actionIndex()
	{
	 $JudicialPlaces=[1=>//танец
 				[11=>//пара
 					[3,3,3,2,3],//судьи
 				2=>
 					[6,6,6,6,5],
 				3=>
 					[2,2,5,4,1],
 				4=>
 					[4,4,2,3,4],
 				5=>
 					[1,5,1,1,2],
 				6=>
 					[5,1,4,5,6],
 				],
 			2=>//танец
 				[11=>//пара
 					[1,5,1,1,2],//судьи
 				2=>
 					[2,2,5,4,1],
 				3=>
 					[3,3,3,2,3],
 				4=>
 					[4,4,2,3,4],
 				5=>
 					[5,1,4,5,5],
 				6=>
 					[6,6,6,6,6],
 				],
 			3=>//танец
 				[11=>//пара
 					[1,1,1,4,4],//судьи
 				2=>
 					[3,2,2,1,1],
 				3=>
 					[2,5,5,2,2],
 				4=>
 					[4,3,4,5,3],
 				5=>
 					[5,4,3,3,5],
 				6=>
 					[6,6,6,6,6],
 				],
 			4=>//танец
 				[11=>//пара
 					[1,1,1,4,4],//судьи
 				2=>
 					[3,2,2,1,1],
 				3=>
 					[2,5,5,2,2],
 				4=>
 					[4,3,4,5,3],
 				5=>
 					[5,4,3,3,5],
 				6=>
 					[6,6,6,6,6],
 				],
 			5=>//танец
 				[11=>//пара
 					[1,1,1,4,4],//судьи
 				2=>
 					[3,2,2,1,1],
 				3=>
 					[2,5,5,2,2],
 				4=>
 					[4,3,4,5,3],
 				5=>
 					[5,4,3,3,5],
 				6=>
 					[6,6,6,6,6],
 				],

 			];
			
		$scating = new Scating($JudicialPlaces);//расчет мест			
		return $this->render('about', ['message' => '<pre>' . $scating->log. '</pre>']);
}}