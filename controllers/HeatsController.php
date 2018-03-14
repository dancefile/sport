<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Volod\TurInfo;
use kartik\grid\EditableColumnAction;

class HeatsController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	
	public function actionNew1($idT=0,$name='',$value='') //задаем заходы автоматом
	{
		$arr=explode('_', $name);
		if (count($arr)==2) {
            $in = (new \yii\db\Query()) 
                ->select(['id'])
                ->from('in')
                ->where(['tur_id' => $idT,'nomer' => $arr[0]])		
				->one();
			if (isset($in['id'])) {
				if (!$arr[1]) $arr[1]=NULL;
				 Yii::$app->db->createCommand()->delete('in_dance', ['id_in' => $in['id'],'dance_id' =>$arr[1]])->execute();
				Yii::$app->db->createCommand()->insert('in_dance', [
									'id_in' => $in['id'],
									'dance_id' => $arr[1],
									'zahod' => $value
									])->execute();	
			}
		}
	}
        
        
	public function actionNew($idT=0) //задаем заходы автоматом
	{
            	$turInfo = new TurInfo;
		$turInfo->setTur($idT);
		$inArr=$turInfo->getIn();
            if (!$turInfo->gettur("typezahod")) return $this->error('Не найден тур или не задан способ формирования заходов');
            if (!$turInfo->gettur("zahodcount")) return $this->error('Не верное кол. заходов');
            
            $couplePerHeat=ceil(count($inArr)/$turInfo->gettur("zahodcount"));
            $insetArr=[];
            switch ($turInfo->gettur("typezahod")) {
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
		
        //    return $this->actionIndex($idT);
	}
	
	public function actionIndex($idT=0,$ved=0) //отбражаем заходы тура
	{
		$turInfo = new TurInfo;
		$turInfo->setTur($idT);

            if (!$turInfo->gettur("typezahod")) return $this->error('Не найден тур или не задан способ формирования заходов');
		
            switch ($turInfo->gettur("typezahod")) {
                case '1':
                case '2':
                    $arrDance=[0=>'Заход'];
                break;

                case '3':
                    $arrDance = $turInfo->getDances();
                break;	
                default:
                   return $this->error('Не задан способ формирования заходов для этого тура');
                    break;
            }

		if ($ved)  
                    return $this->render('viewVed', [
                    'arrDance' => $arrDance,
                    'turInfo' => $turInfo,
                    'dataProvider' => $turInfo->search(Yii::$app->request->queryParams,null),
                ]);
		else
            return $this->render('view', [
                'arrDance' => $arrDance,
                'turInfo' => $turInfo,
                'dataProvider' => $turInfo->search(Yii::$app->request->queryParams,$arrDance),
					]);
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