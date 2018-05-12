<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\FPDF;
use app\models\Volod\TurInfo;
use app\models\Volod\Competition;

class PrintController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	

	public function actionVkleika($idT=13)
	{
		$Competition = new Competition;
		$turInfo = new TurInfo;
		$turInfo->setTur($idT);

		$firsttur = (new \yii\db\Query()) //получаем инфу о данном туре
	    ->select(['id'])
	    ->from('tur')
	    ->where(['category_id' => $turInfo->gettur('id')])
		->orderBy(['nomer' => SORT_ASC])
		->one();	

		if (!isset($firsttur['id'])) return $this->error('Не найден тур или категория');
		
		$COUNTallCouple = (new \yii\db\Query()) //получаем список пар  за текущей тур
    	->select(['COUNT'=>'COUNT(*)'])
    	->from('in')
    	->where(['tur_id' => $firsttur['id']])
		->one();

		switch ($turInfo->gettur("typeSkating")) {
          case '1'://балы

          break;
		  case '2'://кресты
           	$resultCouple=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT, 'dance_id' => null, 'nextTur' => 0])
					->orderBy(['place' => SORT_DESC]);
			foreach ($results->each() as $result) {
				$resultCouple[$result['nomer']]=['place' => $result['place']];
			}
			return $this->render('vkleika', ['turInfo' => $turInfo,'resultCouple' => $resultCouple, 'Competition' => $Competition, 'COUNTallCouple'=> $COUNTallCouple['COUNT']]);
		  
          break;
		  case '3'://скейтинг
		            	$resultCouple=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT, 'dance_id' => null])
					->orderBy(['place' => SORT_DESC]);
			foreach ($results->each() as $result) {
				$resultCouple[$result['nomer']]=['place' => $result['place']];
			}
			return $this->render('vkleika', ['turInfo' => $turInfo,'resultCouple' => $resultCouple, 'Competition' => $Competition, 'COUNTallCouple'=> $COUNTallCouple['COUNT']]);
          break;

		  
		}	
	return $this->error('что то пошло не так :(');	
	}


	public function actionDiplompdf($idT=13)
	{
		$Competition = new Competition;
		$turInfo = new TurInfo;
		$turInfo->setTur($idT);

                $pdf = new FPDF('P','mm','A4');
                $pdf->AddFont('Arial','','arial.php');
                $pdf->AliasNbPages();
        $pdf->SetMargins(5,5,5);
$pdf->SetAutoPageBreak('On',5);
		switch ($turInfo->gettur("typeSkating")) {
          case '1'://балы
          	$resultCouple=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT])
					->orderBy(['result' => SORT_DESC]);
			foreach ($results->each() as $result) {
				$resultCouple[$result['nomer']]=['bal'=>$result['result'],'stepen' => $result['place']];
			}	          
			$this->renderPartial('diplomeBalPdf', ['pdf'=>$pdf,'turInfo' => $turInfo,'resultCouple' => $resultCouple, 'Competition' => $Competition]);
          break;
		  case '2'://кресты
          break;
		  case '3'://скейтинг
		            	$resultCouple=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT, 'dance_id' => null])
					->orderBy(['place' => SORT_DESC]);
			foreach ($results->each() as $result) {
				$resultCouple[$result['nomer']]=['place' => $result['place']];
			}
			$this->renderPartial('diplomePdf', ['pdf'=>$pdf,'turInfo' => $turInfo,'resultCouple' => $resultCouple, 'Competition' => $Competition]);
          break;

		  
		}	
	$pdf->Output();   
	}

        
        
        public function actionDiplom($idT=13)
	{
		$Competition = new Competition;
		$turInfo = new TurInfo;
		$turInfo->setTur($idT);

		switch ($turInfo->gettur("typeSkating")) {
          case '1'://балы
          	$resultCouple=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT])
					->orderBy(['result' => SORT_DESC]);
			foreach ($results->each() as $result) {
				$resultCouple[$result['nomer']]=['bal'=>$result['result'],'stepen' => $result['place']];
			}	          
			return $this->render('diplomeBal', ['turInfo' => $turInfo,'resultCouple' => $resultCouple, 'Competition' => $Competition]);
          break;
		  case '2'://кресты
          break;
		  case '3'://скейтинг
		            	$resultCouple=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT, 'dance_id' => null])
					->orderBy(['place' => SORT_DESC]);
			foreach ($results->each() as $result) {
				$resultCouple[$result['nomer']]=['place' => $result['place']];
			}
			return $this->render('diplome', ['turInfo' => $turInfo,'resultCouple' => $resultCouple, 'Competition' => $Competition]);
          break;

		  
		}	
	return $this->error('что то пошло не так :(');	
	}
        
        
        
        
	public function actionList($idT=13)
	{
         
        $pdf = new FPDF('P','mm','A4');
	$pdf->AddFont('Arial','','arial.php');
	$pdf->AliasNbPages();
	  
        
        $arr=  explode(',', $idT) ;
           $str='';
           foreach ($arr as $id) { 
        	$turInfo = new TurInfo;
		$turInfo->setTur($id);
		$Competition = new Competition;
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
          if ($turInfo->getTur('dancing_order')==1) {
			$this->renderPartial('begunAllHeats', ['pdf'=>$pdf,'turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'балы', 'prosmotr'=>False, 'Competition' => $Competition]);
			} else { 
                              $this->renderPartial('begunpdf', ['pdf'=>$pdf,'turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'балы', 'prosmotr'=>False, 'Competition' => $Competition]);
                        }
          break;
		  case '2'://кресты
			 $this->renderPartial('begunpdf', ['pdf'=>$pdf,'turInfo' => $turInfo, 'judge' =>$judge, 'pole' => FALSE, 'polename' => '', 'prosmotr'=>FALSE, 'Competition' => $Competition]);
          break;
		  case '3'://скейтинг
			 $this->renderPartial('begunpdf', ['pdf'=>$pdf,'turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'места', 'prosmotr'=>FALSE, 'Competition' => $Competition]);
          break;

		  
		}
        

        
        
           }
        
    
       $pdf->Output();   
            
        }
        
	public function actionBegun($idT=13)
	{
           $arr=  explode(',', $idT) ;
           $str='';
           foreach ($arr as $id) { 
            
		$turInfo = new TurInfo;
		$turInfo->setTur($id);
		$Competition = new Competition;
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
          if ($turInfo->getTur('dancing_order')==1) {
			$str.= $this->renderPartial('balAllHeats', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'балы', 'prosmotr'=>False, 'Competition' => $Competition]);
			} else $str.= $this->renderPartial('bal', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'балы', 'prosmotr'=>False, 'Competition' => $Competition]);
          break;
		  case '2'://кресты
			$str.= $this->renderPartial('bal', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => FALSE, 'polename' => '', 'prosmotr'=>FALSE, 'Competition' => $Competition]);
          break;
		  case '3'://скейтинг
			$str.= $this->renderPartial('bal', ['turInfo' => $turInfo, 'judge' =>$judge, 'pole' => TRUE, 'polename' => 'места', 'prosmotr'=>FALSE, 'Competition' => $Competition]);
          break;

		  
		}
               $str.= '<div class="next-page"> </div>';
        }
        
                 return $this->render('about', ['message'=>$str]);
	//return $this->error('что то пошло не так :(');
	}
	
	public function actionReporttur($idT=1)
	{
		$Competition = new Competition;
		$turInfo = new TurInfo;
		$turInfo->setTur($idT);
		$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname','chess.nomer'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $turInfo->getTur('id')])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
		$judge=[];
		$judgeName=[];
		foreach ($judges->each() as $row) {
			$judgeName[$row['id']]=$row['nomer'].'. '.$row['sname'].' '.$row['name'];
			$judge[$row['id']]=$row['nomer'];
		}
		asort($judge);
	
		
			$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball','judge_id'])
    			->from('krest')
    			->where(['tur_id' => $idT]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($judge[$row['judge_id']])) $krestArr[$row['nomer']][$row['dance_id']][$judge[$row['judge_id']]]=$row['ball'];
				}
		$resultsArr=[];
					$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $idT]);
					switch ($turInfo->gettur('typeSkating')) {
						case '1'://подсчет балов
					$results->orderBy(['result' => SORT_DESC,'nomer' => SORT_ASC]);
									break;
				
			case '2'://подсчет крестов
					$results->orderBy(['result' => SORT_DESC,'nomer' => SORT_ASC]);	
				break;
			
			case '3'://скайтинг
			$results->andWhere(['dance_id' => null])
			->orderBy(['nomer' => SORT_ASC]);
			
						};
				 foreach ($results->each() as $result) {
				 $resultsArr[$result['nomer']]=['place'=>$result['place'],'result' => $result['result'], 'nextTur' => $result['nextTur']];	
				 }
		
	return $this->render('ReportTur', ['turInfo' => $turInfo, 'judgeName' =>$judgeName, 'Competition' => $Competition, 'krestArr' => $krestArr, 'resultsArr' => $resultsArr, 'judge' => $judge]);	
	}
	
	
	
	
	
	
	
	
	public function actionIndex()
	{
		function findDancer($id)
		{
		 $dancer = (new \yii\db\Query()) 
		 ->select(['dancer.name','dancer.sname','clubName'=>'club.name','cityName'=>'city.name','clasLaName'=>'clasLa.name','clasStname'=>'clasSt.name'])
		->from('dancer')
		->leftJoin('club','dancer.club=club.id')
		->leftJoin('city','club.id=city.id')
		->leftJoin('clas as clasLa','dancer.clas_id_st=clasLa.id')
		->leftJoin('clas as clasSt','dancer.clas_id_la=clasSt.id')
        ->where(['dancer.id'=>$id])
		->one();	
		return $dancer;
		}


		function findTrener($dancerId)
		{
		 $trener = (new \yii\db\Query()) 
		 ->select(['trener.name','trener.sname'])
		->from('dancer_trener')
		->leftJoin('trener','dancer_trener.trener_id=trener.id')
		->where(['in', 'dancer_trener.dancer_id',$dancerId]);
		$treners=[];
		foreach ($trener->each() as $row) {
			$chek=true;
			 foreach ($treners as $tren) {
				if ($tren['name']==$row['name'] && $tren['sname']==$row['sname']) $chek=false;
			}
			if ($chek) {$treners[]=['name'=>$row['name'],'sname'=>$row['sname']];}
		}
		return $treners;
		}


$Competition = new Competition;
$xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><DanceData version="2.1"></DanceData>');


		$dancesquery = (new \yii\db\Query()) //id категорий по которым есть результаты
	    ->from('dance');

		$dancesname=[];
		foreach ($dancesquery->each() as $rowdances) {
			$dancesname[$rowdances['id']]=$rowdances['name'];
		}
		$Categories = (new \yii\db\Query()) //id категорий по которым есть результаты
	    ->select(['`tur`.`category_id`'])
		->distinct()
	    ->from(['results','tur'])
	    ->where('`results`.`tur_id`=`tur`.`id`')
	    ->andWhere('`tur`.`status`!=-1');
		
		foreach ($Categories->each() as $row) {
			$GroupData = $xml->addChild('GroupData');
			$Header = $GroupData->addChild('Header');
			$Header->addAttribute('language','Russian');
			$Header->addChild('Title', $Competition->shortname)->addAttribute('compDate',$Competition->data);
			$Header->addChild('Organizer', $Competition->org);
			$Header->addChild('Chief', $Competition->chief);
			$category = (new \yii\db\Query()) //имя категории
    			->select(['name'])
    			->from('category')
    			->where(['id' => $row['category_id']])
				->one();
			$Header->addChild('Group',$category['name']);		
			$Couples=$GroupData->addChild('Registration')->addChild('Couples');
			
			
						$Judgesxml=$GroupData->addChild('Judges');
					$judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge.id','judge.name','judge.sname','chess.nomer'])
	    ->from('chess,judge')
	    ->where(['chess.category_id' => $row['category_id']])
		->andWhere('`judge`.`id`=`chess`.`judge_id`');
		$judge=[];
		$judgeName=[];
		foreach ($judges->each() as $judgesrow) {
			$tmp=$Judgesxml->addChild('Judge');
			$tmp->addAttribute('id',$judgesrow['nomer']);
			$judge[$judgesrow['id']]=$judgesrow['nomer'];
			$tmp->addAttribute('firstName',$judgesrow['name']);
			$tmp->addAttribute('lastName',$judgesrow['sname']);
			}
			
			$judgeCount=count($judge);
			
		$turs = (new \yii\db\Query()) //id категорий по которым есть результаты
	    ->select(['`id`','nomer','name','dances'])
	    ->from(['tur'])
	    ->where(['category_id'=>$row['category_id']])
		->orderBy(['nomer' => SORT_ASC]);
		$firtstur=true;
		$Resultsxml=$GroupData->addChild('Results');
		foreach ($turs->each() as $rowTur) {
			
			if ($firtstur) {
				$in = (new \yii\db\Query()) //получаем список пар  за текущей тур
            	->select(['in.id','in.nomer','in.who','couple.dancer_id_1','couple.dancer_id_2'])
	    		->from('in')
				->innerJoin('couple','in.couple_id=couple.id')
                ->where(['tur_id' => $rowTur['id']]);	
            foreach ($in->each() as $rowin) {
            		
            	$Couple[$rowin['nomer']]=$Couples->addChild('Couple');
				$Couple[$rowin['nomer']]->addAttribute('n',$rowin['nomer']);
				switch ($rowin['who']) {
					case '1':
					$dancerrow=findDancer($rowin['dancer_id_1']);
					$trenerArr=findTrener([$rowin['dancer_id_1']]);
					$tmp=$Couple[$rowin['nomer']]->addChild('Male');
					$tmp->addAttribute('firstName',$dancerrow['name']);
					$tmp->addAttribute('lastName',$dancerrow['sname']);
					$tmp=$Couple[$rowin['nomer']]->addChild('Club');
					$tmp->addAttribute('city',$dancerrow['cityName']);
					$tmp->addAttribute('name',$dancerrow['clubName']);
					
					break;
					case '2':
						
					$dancerrow=findDancer($rowin['dancer_id_2']);
					$trenerArr=findTrener([$rowin['dancer_id_2']]);
					$tmp=$Couple[$rowin['nomer']]->addChild('Female');
					$tmp->addAttribute('firstName',$dancerrow['name']);
					$tmp->addAttribute('lastName',$dancerrow['sname']);
					$tmp=$Couple[$rowin['nomer']]->addChild('Club');
					$tmp->addAttribute('city',$dancerrow['cityName']);
					$tmp->addAttribute('name',$dancerrow['clubName']);
					
					break;
					default:
					$dancerrow=findDancer($rowin['dancer_id_2']);
					$trenerArr=findTrener([$rowin['dancer_id_1'],$rowin['dancer_id_2']]);
					$tmp=$Couple[$rowin['nomer']]->addChild('Female');
					$tmp->addAttribute('firstName',$dancerrow['name']);
					$tmp->addAttribute('lastName',$dancerrow['sname']);

					$dancerrow=findDancer($rowin['dancer_id_1']);
					$tmp=$Couple[$rowin['nomer']]->addChild('Male');
					$tmp->addAttribute('firstName',$dancerrow['name']);
					$tmp->addAttribute('lastName',$dancerrow['sname']);
					$tmp=$Couple[$rowin['nomer']]->addChild('Club');
					$tmp->addAttribute('city',$dancerrow['cityName']);
					$tmp->addAttribute('name',$dancerrow['clubName']);
					
					break;
				
			}
			$i=1;
			foreach ($trenerArr as $key => $value) {
				$tmp->addAttribute('trener'.$i.'LastName',$value['sname']);		
				$tmp->addAttribute('trener'.$i.'FirstName',$value['name']);
				$i++;
						}
						}

		
		 $firtstur=false; }	


			
			$krest = (new \yii\db\Query()) //получаем оценки всех судей за текущей тур
    			->select(['dance_id','nomer','ball','judge_id'])
    			->from('krest')
    			->where(['tur_id' => $rowTur['id']]);	
		
				$krestArr=[];
				foreach ($krest->each() as $row) {
					if (isset($judge[$row['judge_id']])) $krestArr[$row['nomer']][$row['dance_id']][$judge[$row['judge_id']]]=$row['ball'];
				}

		$Roundxml=$Resultsxml->addChild('Round');
		$Roundxml->addAttribute('no', $rowTur['nomer']);
		$Roundxml->addAttribute('name', $rowTur['name']);
		$Totalxml=$Roundxml->addChild('Total');
	          	$resultDance=[];
          	$results = (new \yii\db\Query()) //получаем инфу о данном туре
				    ->from('results')
	    			->where(['tur_id' => $rowTur['id']]);
			foreach ($results->each() as $result) {
				if (!$result['dance_id']) $result['dance_id']=0;
				$resultDance[$result['dance_id']][$result['nomer']]=['result'=>$result['result'],'place' => $result['place']];
			}	
			foreach ($resultDance[0] as $key => $value) {
				$Resultxml=$Totalxml->addChild('Result');
				$Resultxml->addAttribute('n', $key);
				$Resultxml->addAttribute('sum', $value['result']);
				$Resultxml->addAttribute('place', $value['place']);
			}			
				
		$dancesArr = explode(',',str_replace(' ','',$rowTur['dances']));	
		$Dancesxml=$Roundxml->addChild('Dances');	
		$i=1;	
	foreach ($dancesArr as $danceId) {
		$Dancexml=$Dancesxml->addChild('Dance');
		$Dancexml->addAttribute('no', $i);
		$Dancexml->addAttribute('name', $dancesname[$danceId]);
		
		foreach ($resultDance[0] as $key => $value) {
		 $arr=array_fill ( 1 , $judgeCount , '-' );
			if (isset($krestArr[$key][$danceId]))
						foreach ($krestArr[$key][$danceId] as $Jnomer => $ballorkrest) {
							$arr[$Jnomer]=$ballorkrest;
						}
			
				$Resultxml=$Dancexml->addChild('Result',implode($arr));
				$Resultxml->addAttribute('n', $key);
				if (isset($resultDance[$danceId])) {
					$Resultxml->addAttribute('sum', $resultDance[$danceId][$key]['result']);
					$Resultxml->addAttribute('place', $resultDance[$danceId][$key]['place']);
				}
		}			
						
		
		$i++;
	}

					//	<Result n="8" sum="1" head="1">X-----</Result>
					//	<Result n="23" sum="4" head="1">-XXX-X</Result>
		
			
			}
			

		}
		




file_put_contents('C:\Users\Toshiba 6\Desktop\bd.xml', $xml->asXML());
return $this->render('about', ['message' => '<pre>' . 'ok'. '</pre>']);

/*
	$sxe = new \SimpleXMLElement($xmlstr);
$sxe->addAttribute('type', 'documentary');

$movie = $sxe->addChild('movie');
$movie->addChild('title', 'PHP2: Истории парсера');
$movie->addChild('plot', 'Все о людях, создававших его.');

$characters = $movie->addChild('characters');
$character  = $characters->addChild('character');
$character->addChild('name', 'Mr. Parser');
$character->addChild('actor', 'John Doe');

$rating = $movie->addChild('rating', '5');
$rating->addAttribute('type', 'stars');
 
echo $sxe->asXML();	
/*		
		
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
		
		
		
		*/
		
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