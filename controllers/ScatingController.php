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
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['tur.category_id','turname'=>'tur.name','tur.ParNextTur','tur.nomer','category.name','tur.typeSkating'])
	    ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();
		
		if (!isset($tur['name'])) return $this->error('Не найден тур или категория');
	
		$nexttur = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['id','name','nomer'])
	    ->from('tur')
	    ->where(['category_id' => $tur['category_id']])
		->andWhere(['>', 'nomer', $tur['nomer']])
		->orderBy(['nomer' => SORT_ASC])
		->one();	
	
		if (!isset($nexttur['id'])) return $this->error('Не найден следующий тур');	
		
		$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    	->select(['dance_id','nomer','ball'])
    	->from('krest')
    	->where(['tur_id' => $idT]);	
		
		$krestArr=[];
		
		foreach ($krest->each() as $row) {
			if (isset($krestArr[$row['nomer']])) $krestArr[$row['nomer']]++;
			else $krestArr[$row['nomer']]=1;
		}
	
		$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    	->select(['nomer','couple_id','who'])
    	->from('in')
    	->where(['tur_id' => $idT]);	
		
		foreach ($in->each() as $row) {
			$inArr[]=$row['nomer'];	
			$couple_idArr[$row['nomer']]=$row['couple_id'];
			$whoArr[$row['nomer']]=$row['who'];		
		}	

		$innext = (new \yii\db\Query()) //получаем список пар  за след тур
    	->select(['nomer','id'])
    	->from('in')
    	->where(['tur_id' => $nexttur['id']]);
		$delIn=[];
		foreach ($innext->each() as $row) {
		 if (in_array ($row['nomer'],$inArr)) {$delIn[]=$row['id'];}	
		}
				
		if (count($delIn)) Yii::$app->db->createCommand()->delete('in', ['in','id',$delIn])->execute();

		arsort($krestArr);
		$i=0;
		$insetArr=[];
		foreach($krestArr as $nomer => $krest){
    	$i++;
		$insetArr[]=[$couple_idArr[$nomer], $nexttur['id'], $nomer, $whoArr[$nomer]];	
		if ($count==$i) {break;}		
    	}
		
		Yii::$app->db->createCommand()->batchInsert('in', ['couple_id', 'tur_id', 'nomer', 'who'], $insetArr)->execute();
		
		return $this->actionInput($nexttur['id']);	
	}//actionKrest

    private function error($message) //вывод критических ошибок
	{
		return $this->render('about', ['message' => '<pre> Ошибка! ' .$message. '</pre>']);	
	}//error

	public function actionCalc($idT=0) //подсчет результатов тура
	{
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['tur.category_id','turname'=>'tur.name','tur.ParNextTur','tur.dances','tur.nomer','category.name','tur.typeSkating'])
	    ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();
		
		if (!isset($tur['name'])) return $this->error('Не найден тур или категория');
	
		switch ($tur["typeSkating"]) { //подсчет результатов тура в зависимости от способа подсчета
			case '1'://подсчет балов
				$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball'])
    			->from('krest')
    			->where(['tur_id' => $idT]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($krestArr[$row['nomer']])) $krestArr[$row['nomer']]=$krestArr[$row['nomer']]+$row['ball'];
					else $krestArr[$row['nomer']]=$row['ball'];
				}
				
				$inArr=[];
				$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    			->select(['nomer'])
    			->from('in')
    			->where(['tur_id' => $idT]);	
		
				foreach ($in->each() as $row) {
					$inArr[]=$row['nomer'];	
				}	
				
				arsort($krestArr);
				$judgesArr=[];
				$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    		->select(['judge.id','judge.name','judge.sname'])
	    		->from('chess,judge')
	    		->where(['chess.category_id' => $tur['category_id']])
				->andWhere('`judge`.`id`=`chess`.`judge_id`');
	
				foreach ($judges->each() as $row) {
					$judgesArr[$row['id']]=$row['sname'].' '.$row['name']; 
				}
				
				$dancesArr = explode(',',str_replace(' ','',$tur['dances']));
				$count=count($dancesArr)*count($judgesArr);
				return $this->render('ball', [
								'count' => $count,
								'tur' => $tur,
								'inArr' => $inArr,
								'krestArr' => $krestArr,
								'idT' => $idT]);
								
				break;
			
			case '2'://подсчет крестов
				$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball'])
    			->from('krest')
    			->where(['tur_id' => $idT]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($krestArr[$row['nomer']])) $krestArr[$row['nomer']]++;
					else $krestArr[$row['nomer']]=1;
				}
				$inArr=[];
				$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    			->select(['nomer'])
    			->from('in')
    			->where(['tur_id' => $idT]);	
		
				foreach ($in->each() as $row) {
					$inArr[]=$row['nomer'];	
				}	
				
				arsort($krestArr);
				
				return $this->render('krest', [
								'tur' => $tur,
								'inArr' => $inArr,
								'krestArr' => $krestArr,
								'idT' => $idT]);		
				break;
			
			case '3'://скайтинг
				
				$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball','judge_id'])
    			->from('krest')
    			->where(['tur_id' => $idT]);
				
				$JudicialPlaces=[];
				foreach ($krest->each() as $row) {
					$JudicialPlaces[$row['dance_id']][$row['nomer']][$row['judge_id']]=$row['ball'];	
				}

				$scating = new Scating($JudicialPlaces);//расчет мест			
				return $this->render('about', ['message' => '<pre>' . $scating->log. '</pre>']);
				break;
			default:
				return $this->error('не задан способ подсчета результатов');	
				break;
		}

	}//actionCalc



	public function actionForm($idT=0,$idD=0) //ввод оченок судей парам за танец
	{
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['tur.category_id','turname'=>'tur.name','tur.dances','category.name','tur.typeSkating'])
	    ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();
		
		if (!isset($tur['name'])) return $this->error('Не найден тур или категория');
		
		$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $tur['category_id']])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
	
		foreach ($judges->each() as $row) {
			$judgesArr[$row['id']]=$row['sname'].' '.$row['name']; 
		}
	
		$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей танец за текущей тур
    	->select(['judge_id','dance_id','nomer','ball'])
    	->from('krest')
    	->where(['tur_id' => $idT, 'dance_id' => $idD]);	
		
		$krestArr=[];
		foreach ($krest->each() as $row) {
			$krestArr[$row['judge_id']][$row['nomer']]=$row['ball'];	
		}
	
		$in = (new \yii\db\Query()) //получаем список пар в текущем танеце за текущей тур
    	->select(['nomer'])
    	->from('in')
    	->where(['tur_id' => $idT]);	
		$inArr=[];
		foreach ($in->each() as $row) {
			$inArr[]=$row['nomer'];	
		}
		
		$dance = (new \yii\db\Query()) //получаем имя текущего танца тура
    	->select(['name','id'])
    	->from('dance')
    	->where(['id' => $idD])
		->one();
		
	return $this->render('form', ['inArr' => $inArr,
								 'krestArr' => $krestArr,
								 'judgesArr' => $judgesArr,
								 'tur' => $tur,
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
		
		Yii::$app->db->createCommand()->batchInsert('krest', ['judge_id', 'tur_id', 'dance_id', 'nomer', 'ball'], $insetArr)->execute();

		return self::actionInput($idT);
	}//actionEntry
	
	
	public function actionInput($idT=0) //ввывод количестава оценок судей за каждый танец
	{
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['tur.category_id','turname'=>'tur.name','tur.dances','category.name'])
	    ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();
		
		if (!isset($tur['name'])) return $this->error('Не найден тур или категория');	
	
		$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $tur['category_id']])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
	
		foreach ($judges->each() as $row) {
			$judgesArr[$row['id']]=$row['sname'].' '.$row['name']; 
		}
	
		$krest = (new \yii\db\Query()) //получаем оценки всех судей за все танцы за текущей тур
    	->select(['judge_id','dance_id','nomer','ball'])
    	->from('krest')
    	->where(['tur_id' => $idT]);	
		
		$krestArr=[];
		foreach ($krest->each() as $row) {
			$krestArr[$row['judge_id']][$row['dance_id']][$row['nomer']]=$row['ball'];	
		}
	
		$dancesArr = array_fill_keys(explode(',',str_replace(' ','',$tur['dances'])), '');
		$Dance = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
    	->from('dance')
    	->where(['in', 'id',array_keys($dancesArr)]);	
		foreach ($Dance->each() as $row) {
			if (isset($dancesArr[$row['id']])) $dancesArr[$row['id']]=$row['name']; 
		}
	
	return $this->render('list', ['dancesArr' => $dancesArr, 'krestArr' => $krestArr, 'judgesArr' => $judgesArr, 'tur' => $tur, 'idT' => $idT]);	
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