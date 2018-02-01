<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\FPDF;
use app\models\Volod\TurInfo;

class PrintController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	


	public function actionList($idT=13)
	{
		$turInfo = new TurInfo;
		$turInfo->setTur($idT);

		$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname','chess.nomer'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $turInfo->getTur('id')])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
		$judge=[];
		foreach ($judges->each() as $row) {
			$judge[$row['id']]=$row['nomer'].'. '.$row['sname'].' '.$row['name'];
		}
		asort($judge);
				
		switch ($turInfo->gettur("typeSkating")) {
          case '1'://балы
			return $this->render('balAllHeats', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'балы', 'prosmotr'=>true]);
          break;
		  case '2'://кресты
			return $this->render('bal', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => FALSE, 'polename' => '', 'prosmotr'=>FALSE]);
          break;
		  case '3'://скейтинг
			return $this->render('bal', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'места', 'prosmotr'=>FALSE]);
          break;

		  
		}

	return $this->error('что то пошло не так :(');
	}
	
	public function actionIndex($idС=11)
	{
	$pdf = new FPDF('L');
	$pdf->AddFont('Arial','','arial.php');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',15);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'Открытый турнир МОТЛ "Зимняя Сказка"'),0,1,'C');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'20.01.2018 ТЗ "Пингвин"'),0,1,'C');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',15);
	
	$tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['name'])
	    ->from('category')
		->where(['category.id'=>$idС])
		->one();
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$tur['name']),0,1,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'Судейская бригада:'),0,1,'C');
	
	$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname','chess.nomer'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $idС])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
	
		foreach ($judges->each() as $row) {
			$pdf->Ln(5);
			$judge[$row['id']]=$row['nomer'];
			$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$row['nomer'].'. '.$row['sname'].' '.$row['name']),0,1,'C');
		}
		asort($judge);
		$judgeCount=count($judge);	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'Регистрация:'),0,1,'C');
	$pdf->Ln(5);
 $pdf->SetFillColor(224,224,224);
    // Header
    $header = array('№', 'Участники', 'Город', 'Клуб', 'Руководитель', 'Тренеры');
	$w = array(10,60,30,30,30,50,20,20,20,20,20);
    
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],5,iconv("UTF-8","Windows-1251",$header[$i]),1,0,'C',true);
    $pdf->Ln();

		 
		$nexttur = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['id','name','nomer'])
	    ->from('tur')
	    ->where(['category_id' => $idС])
		->orderBy(['nomer' => SORT_ASC])
		->one();	
		 
		 if (!isset($nexttur['id'])) return $this->error('Не найден тур или категория');
		 
		$in = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['in.nomer','in.who','couple.dancer_id_1','couple.dancer_id_2'])
	    ->from('in')
		->innerJoin('couple','in.couple_id=couple.id')
		->where(['in.tur_id'=>$nexttur['id']]);
		
		$coupleName=[];
		$coupleInfo=[];
		foreach ($in->each() as $row) {
			switch ($row['who']) {
				case '1':
					$this->dancer_id($coupleName, $coupleInfo, $row['nomer'], $row['dancer_id_1']);
				break;
				case '2':
					$this->dancer_id($coupleName, $coupleInfo, $row['nomer'], $row['dancer_id_2']);
				break;
				case '3':
					$this->dancer_id($coupleName, $coupleInfo, $row['nomer'], $row['dancer_id_1']);
					$this->dancer_id($coupleName, $coupleInfo, $row['nomer'], $row['dancer_id_2']);
				break;
				
			}
		}
		
		asort($coupleName);
		$pdf->SetFillColor(224,235,255);
		$fill = false;
		foreach ($coupleName as $nomer => $Name) {
			$pdf->Cell($w[0],7,iconv("UTF-8","Windows-1251",$nomer),1,0,'C',$fill);
			$pdf->Cell($w[1],7,iconv("UTF-8","Windows-1251",$Name),1,0,'C',$fill);
			$pdf->Cell($w[2],7,iconv("UTF-8","Windows-1251",$coupleInfo[$nomer]['city']),1,0,'C',$fill);
			$pdf->Cell($w[3],7,iconv("UTF-8","Windows-1251",$coupleInfo[$nomer]['club']),1,0,'C',$fill);
			$pdf->Cell($w[4],7,iconv("UTF-8","Windows-1251",$coupleInfo[$nomer]['trener']),1,0,'C',$fill);
			$pdf->Cell($w[5],7,iconv("UTF-8","Windows-1251",$coupleInfo[$nomer]['trener']),1,0,'C',$fill);
    		$pdf->Ln();
			$fill=!$fill;
		 }	
		 
		 
		 
		 		 
		$turs = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['id','name','nomer','typeSkating','dances'])
	    ->from('tur')
	    ->where(['category_id' => $idС])
		->orderBy(['nomer' => SORT_ASC]);
		 foreach ($turs->each() as $tursCurent) {
		 
		$pdf->AddPage();
		$pdf->SetFont('Arial','',15);
		$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'Открытый турнир МОТЛ "Зимняя Сказка"'),0,1,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'20.01.2018 ТЗ "Пингвин"'),0,1,'C');
		$pdf->Ln(5);
		$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$tursCurent['name']),0,1,'C');
		$pdf->Ln(10);
		 switch ($tursCurent['typeSkating']) {
			case '1'://подсчет балов
				$pdf->SetFillColor(224,224,224);
				$pdf->Cell(10,5,iconv("UTF-8","Windows-1251",'№'),1,0,'C',true);
				$pdf->Cell(25,5,iconv("UTF-8","Windows-1251",'Диплом'),1,0,'C',true);
				$pdf->Cell(15,5,iconv("UTF-8","Windows-1251",'Сумма'),1,0,'C',true);
				$dancesArr = array_fill_keys(explode(',',str_replace(' ','',$tursCurent['dances'])), '');
				$Dance = (new \yii\db\Query()) //
    				->from('dance')
    				->where(['in', 'id',array_keys($dancesArr)]);	
				foreach ($Dance->each() as $row) {
					if (isset($dancesArr[$row['id']])) $dancesArr[$row['id']]=$row['name']; 
				}
			
				$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball','judge_id'])
    			->from('krest')
    			->where(['tur_id' => $tursCurent['id']]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($judge[$row['judge_id']])) $krestArr[$row['nomer']][$row['dance_id']][$judge[$row['judge_id']]]=$row['ball'];
				}
				
				$danceWidth=intval(($pdf->GetPageWidth()-$pdf->GetX()-6)/count($dancesArr));
				foreach ($dancesArr as $key => $value) {$pdf->Cell($danceWidth,5,iconv("UTF-8","Windows-1251",$value),1,0,'C',true);	}
				$pdf->Ln();
				$pdf->SetFillColor(224,235,255);
				$fill = false;
				$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $tursCurent['id']])
					->orderBy(['nomer' => SORT_ASC]);
				 foreach ($results->each() as $result) {
		 			$pdf->Cell(10,5,iconv("UTF-8","Windows-1251",$result['nomer']),1,0,'C',$fill);
					$pdf->Cell(25,5,iconv("UTF-8","Windows-1251",$result['place'].' степени'),1,0,'C',$fill);
					$pdf->Cell(15,5,iconv("UTF-8","Windows-1251",$result['result']),1,0,'C',$fill);
					foreach ($dancesArr as $keyDance => $valueDance) {
						$arr=array_fill ( 1 , $judgeCount , '-' );
						if (isset($krestArr[$result['nomer']][$keyDance]))
						foreach ($krestArr[$result['nomer']][$keyDance] as $key => $value) {
							$arr[$key]=$value;
						}
						$pdf->Cell($danceWidth,5,iconv("UTF-8","Windows-1251",implode($arr)),1,0,'C',$fill);
						
					}
					$pdf->Ln();
					$fill=!$fill;
				 }
					
			
			
			
			
			
			
			
			
			
			
			
			break;
				
			case '2'://подсчет крестов
				$pdf->SetFillColor(224,224,224);
				$pdf->Cell(10,5,iconv("UTF-8","Windows-1251",'№'),1,0,'C',true);
				$pdf->Cell(12,5,iconv("UTF-8","Windows-1251",'место'),1,0,'C',true);
				$pdf->Cell(12,5,iconv("UTF-8","Windows-1251",'сумма'),1,0,'C',true);
				$dancesArr = array_fill_keys(explode(',',str_replace(' ','',$tursCurent['dances'])), '');
				$Dance = (new \yii\db\Query()) //
    				->from('dance')
    				->where(['in', 'id',array_keys($dancesArr)]);	
				foreach ($Dance->each() as $row) {
					if (isset($dancesArr[$row['id']])) $dancesArr[$row['id']]=$row['name']; 
				}
				
				$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball','judge_id'])
    			->from('krest')
    			->where(['tur_id' => $tursCurent['id']]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($judge[$row['judge_id']])) $krestArr[$row['nomer']][$row['dance_id']][$judge[$row['judge_id']]]=$row['ball'];
				}
				
				$danceWidth=intval(($pdf->GetPageWidth()-$pdf->GetX()-6)/count($dancesArr));
				foreach ($dancesArr as $key => $value) {$pdf->Cell($danceWidth,5,iconv("UTF-8","Windows-1251",$value),1,0,'C',true);	}
				$pdf->Ln();
				$pdf->SetFillColor(224,235,255);
				$fill = false;
				$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $tursCurent['id']])
					->orderBy(['result' => SORT_DESC,'nomer' => SORT_ASC]);
					$razdel=false;
				 foreach ($results->each() as $result) {
				 	if (!$razdel && !$result['nextTur']) {$razdel=true; $pdf->Ln(3);}
		 			$pdf->Cell(10,5,iconv("UTF-8","Windows-1251",$result['nomer']),1,0,'C',$fill);
					$pdf->Cell(12,5,iconv("UTF-8","Windows-1251",$result['place']),1,0,'C',$fill);
					$pdf->Cell(12,5,iconv("UTF-8","Windows-1251",$result['result']),1,0,'C',$fill);
					foreach ($dancesArr as $keyDance => $valueDance) {
						$arr=array_fill ( 1 , $judgeCount , '-' );
						if (isset($krestArr[$result['nomer']][$keyDance]))
						foreach ($krestArr[$result['nomer']][$keyDance] as $key => $value) {
							$arr[$key]='x';
						}
						$pdf->Cell($danceWidth,5,iconv("UTF-8","Windows-1251",implode($arr)),1,0,'C',$fill);
						
					}
					$pdf->Ln();
					$fill=!$fill;
				 }
				
			break;
			
			case '3'://скайтинг
			 $krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball','judge_id'])
    			->from('krest')
    			->where(['tur_id' => $tursCurent['id']]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($judge[$row['judge_id']])) $krestArr[$row['nomer']][$row['dance_id']][$judge[$row['judge_id']]]=$row['ball'];
				}
			foreach ($dancesArr as $key => $value) {
				$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$value),0,1,'L');
				$pdf->Ln(5);
				$pdf->SetFillColor(224,224,224);
				$pdf->Cell(10,5,iconv("UTF-8","Windows-1251",'№'),1,0,'C',true);
				$pdf->Cell($judgeCount*10,5,iconv("UTF-8","Windows-1251",'Судейские оценки'),1,0,'C',true);
				$pdf->Cell(12,5,iconv("UTF-8","Windows-1251",'место'),1,0,'C',true);
				$pdf->Ln();
				$pdf->SetFillColor(224,235,255);
				$fill = false;
				$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $tursCurent['id'],'dance_id'=>$key])
					->orderBy(['nomer' => SORT_ASC]);
				foreach ($results->each() as $result) {
					if (isset($sum[$result['nomer']])) {$sum[$result['nomer']]=$sum[$result['nomer']]+$result['place'];} else $sum[$result['nomer']]=$result['place'];
					$pdf->Cell(10,6,iconv("UTF-8","Windows-1251",$result['nomer']),1,0,'C',$fill);
					foreach ($judge as $jId => $jNomer) {
					$pdf->Cell(10,6,iconv("UTF-8","Windows-1251",$krestArr[$result['nomer']][$key][$jNomer]),1,0,'C',$fill);	
					}
					$pdf->Cell(12,6,iconv("UTF-8","Windows-1251",$result['place']),1,0,'C',$fill);
					$pdf->Ln();
					$fill=!$fill;
				}
				$pdf->Ln(10);

			}
				$pdf->SetFillColor(224,224,224);
				$pdf->Cell(15,5,iconv("UTF-8","Windows-1251",'номер'),1,0,'C',true);				
				$pdf->Cell(25,5,iconv("UTF-8","Windows-1251",'Сумма мест'),1,0,'C',true);
				$pdf->Cell(12,5,iconv("UTF-8","Windows-1251",'Итог'),1,0,'C',true);
				$pdf->Ln();
				$pdf->SetFillColor(224,235,255);
							$fill = false;
				$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $tursCurent['id'],'dance_id'=> null])
					->orderBy(['nomer' => SORT_ASC]);
				foreach ($results->each() as $result) {
				$pdf->Cell(15,6,iconv("UTF-8","Windows-1251",$result['nomer']),1,0,'C',$fill);				
				$pdf->Cell(25,6,iconv("UTF-8","Windows-1251",$sum[$result['nomer']]),1,0,'C',$fill);
				$pdf->Cell(12,6,iconv("UTF-8","Windows-1251",$result['place']),1,0,'C',$fill);
				$pdf->Ln();
				$fill=!$fill;
				}
			break;
			
			default: return $this->error('не задан способ подсчета результатов');			
		 }
		 
		 
		 }
		 
	$pdf->Output();
		//return $this->render('about', ['message' => '<pre>' . 's'. '</pre>']);
}
    private function dancer_id(&$coupleName,&$coupleInfo,$nomer,$id) //
	{
		$dancer = (new \yii\db\Query()) //получаем инфу о данном туре
	    	->from('dancer')
	    	->where(['id' => $id])
			->one();	
		if (isset($dancer['id'])) {
			if (isset($coupleName[$nomer])) $coupleName[$nomer]= $coupleName[$nomer].' - '.$dancer['sname'].' '.$dancer['name']; else
				$coupleName[$nomer]=$dancer['sname'].' '.$dancer['name'];
			//if (isset($coupleInfo[$nomer])) {
				$coupleInfo[$nomer]['city']='';
				$coupleInfo[$nomer]['club']='';
				$coupleInfo[$nomer]['trener']='';
		};
			
	}//dancer_id

    private function error($message) //вывод критических ошибок
	{
		return $this->render('about', ['message' => '<pre> Ошибка! ' .$message. '</pre>']);	
	}//error


}