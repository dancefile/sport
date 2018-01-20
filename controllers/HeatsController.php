<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\Scating;
use app\models\Otd;

class HeatsController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	
	public function actionNew($idT=0) //задаем заходы автоматом
	{
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['category.id','turname'=>'tur.name','tur.zahodcount','tur.typezahod','tur.dances','category.name'])
	    ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();
		
		$inArr=[];
		$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    	->select(['id','nomer'])
    	->from('in')
    	->where(['tur_id' => $idT]);	
		foreach ($in->each() as $row) {
		$inArr[$row['id']]=$row['nomer'];	
		}		
		
		if (!isset($tur["typezahod"])) return $this->error('Не найден тур или не задан способ формирования заходов');
		$couplePerHeat=ceil(count($inArr)/$tur['zahodcount']);
		$insetArr=[];
		switch ($tur["typezahod"]) {
			case '1':
				asort($inArr);
				$this->headNew($insetArr,$inArr,$couplePerHeat);
				break;
			case '2':
				$this->shuffle_assoc($inArr);
				$this->headNew($insetArr,$inArr,$couplePerHeat);
				break;
			
			case '3':
				$arrDance = array_fill_keys(explode(',',str_replace(' ','',$tur['dances'])), '');;
				$Dance = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
    			->from('dance')
    			->where(['in', 'id',array_keys($arrDance)]);	
				foreach ($Dance->each() as $row) {
					$this->shuffle_assoc($inArr);
					$this->headNew($insetArr,$inArr,$couplePerHeat,$row['id']); 
				}
				break;	
			default:
				if (!isset($tur["typezahod"])) return $this->error('Не задан способ формирования заходов для этого тура');
				break;
		}
		
		Yii::$app->db->createCommand()->delete('in_dance', ['in' , 'id_in', array_keys($inArr)])->execute();
		
		Yii::$app->db->createCommand()->batchInsert('in_dance', ['id_in', 'dance_id', 'zahod'], $insetArr)->execute();
		
		return $this->actionIndex($idT);
	}
	
	public function actionIndex($idT=0) //отбражаем заходы тура
	{
		
		$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['category.id','turname'=>'tur.name','tur.typezahod','tur.typezahod','tur.dances','category.name'])
	    ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();
		
		$inArr=[];
		$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
    	->select(['id','nomer'])
    	->from('in')
    	->where(['tur_id' => $idT]);	
		foreach ($in->each() as $row) {
		$inArr[$row['id']]=$row['nomer'];	
		}
		
		$heatsArr=[];
		$heats = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
    	->from('in_dance')
    	->where(['in', 'id_in',array_keys($inArr)]);	
		foreach ($heats->each() as $row) {
			if (!$row['dance_id']) $row['dance_id']=0;	
			$heatsArr[$row['id_in']][$row['dance_id']]=$row['zahod'];	
		}
		
		if (!isset($tur["typezahod"])) return $this->error('Не найден тур или не задан способ формирования заходов');
		
		switch ($tur["typezahod"]) {
			case '1':
			case '2':
				$arrDance=[0=>'Все'];
					
				break;
			
			case '3':
				$arrDance = array_fill_keys(explode(',',str_replace(' ','',$tur['dances'])), '');;
				$Dance = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
    			->from('dance')
    			->where(['in', 'id',array_keys($arrDance)]);	
				foreach ($Dance->each() as $row) {
					if (isset($arrDance[$row['id']])) $arrDance[$row['id']]=$row['name']; 
				}
				break;	
			default:
				if (!isset($tur["typezahod"])) return $this->error('Не задан способ формирования заходов для этого тура');
				break;
		}
		
		return $this->render('view', ['arrDance' => $arrDance,
								 'tur' => $tur,
								 'heatsArr' => $heatsArr,
								 'inArr'=>$inArr,
								 'idT'=>$idT]);		
	}//actionIndex
	
	
	
	 private function headNew(&$insetArr,$inArr,$couplePerHeat,$idDance=NULL) { //создаем массив для вставки в таблицу in_dance
				$heat=1;
				$countCouple=0;
				foreach ($inArr as $key => $nomer) {
					if ($countCouple==$couplePerHeat) {$heat++;	$countCouple=0;};
					$insetArr[]=[$key,$idDance,$heat];
					$countCouple++;
				}
				return TRUE;
	 }
	 
	   private function shuffle_assoc(&$array) { //перемешивание массива(случайная последовательность)
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }//shuffle_assoc
	
	
	    private function error($message) //вывод критических ошибок
	{
		return $this->render('about', ['message' => '<pre> Ошибка! ' .$message. '</pre>']);	
	}//error
}