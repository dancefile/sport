<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

if (Yii::$app->request->post('programname')!==null) 
{
	$turName=Yii::$app->request->post('programname');

} else {

$turName=$turInfo->gettur('name');
}

$pdf->AddPage('L','A4');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$turInfo->gettur('id').'. '.$turName),0,1,'C'); 
$pdf->Ln(5); 
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,7,iconv("UTF-8","Windows-1251",'Место'),1,0,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(10,7,iconv("UTF-8","Windows-1251",'№'),1,0,'C');
$pdf->Cell(120,7,iconv("UTF-8","Windows-1251",'Участники'),1,0,'C');
$pdf->Cell(40,7,iconv("UTF-8","Windows-1251",'Клуб'),1,0,'C');
$pdf->Cell(30,7,iconv("UTF-8","Windows-1251",'Город'),1,0,'C');
$pdf->Cell(70,7,iconv("UTF-8","Windows-1251",'Тренеры'),1,0,'C');

$pdf->Ln(7);
$pdf->SetFont('Arial','',11);

	$inArr=$turInfo->getIn();

		
			   
	$diploms=[];
    foreach ($resultCouple as $nomer => $result){
    	$key = array_search($nomer, $inArr);
		$names=$turInfo->GetCoupleName($key,'fname','-');
		$diplom=['name'=>$names,'place'=>$result['place'] ];
		$diploms[]=$diplom;
		if (strripos($names,'-')!==false) {
		$diploms[]=$diplom;
		} 
		
    	$data[$nomer] = [	'nomer' => $nomer,
    					'name'=>$names,
    					'club'=>$turInfo->GetCoupleName($key,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($key),
    					'Trener'=>$turInfo->GetCoupleTrener($key),
    					'place'=>$result['place'],
    					];
        
    $pdf->Cell(10,7,iconv("UTF-8","Windows-1251",$result['place']),1,0,'C');    
   $pdf->Cell(10,7,iconv("UTF-8","Windows-1251",$nomer),1,0,'C');
$pdf->Cell(120,7,iconv("UTF-8","Windows-1251",$names),1,0,'L');
$pdf->Cell(40,7,iconv("UTF-8","Windows-1251",$turInfo->GetCoupleName($key,'clubName')),1,0,'C');
$pdf->Cell(30,7,iconv("UTF-8","Windows-1251",$turInfo->GetCoupleCity($key)),1,0,'C');
$pdf->Cell(70,7,iconv("UTF-8","Windows-1251",$turInfo->GetCoupleTrener($key,',')),1,0,'L');


   $pdf->Ln(7); 
        
						
	}
	


	foreach ($diploms as $key=>$diplom) {

            $pdf->AddPage('P','A4');	
	
 $pdf->Ln(150);
 $pdf->SetFont('Arial','',22);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'НАГРАЖДАЕТСЯ'),0,1,'C'); 
 $pdf->Ln(17); 
 $pdf->SetFont('Arial','',17);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$diplom['name']),0,1,'C'); 
 $pdf->Ln(10); 
  $pdf->SetFont('Arial','',17);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'занявшие '.$diplom['place'].' место' ),0,1,'C'); 
 $pdf->Ln(10); 
   $pdf->SetFont('Arial','',12);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'в категории:'),0,1,'C'); 
 $pdf->Ln(10); 
   $pdf->SetFont('Arial','',16);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$turName),0,1,'C'); 
 $pdf->Ln(10); 
   $pdf->SetFont('Arial','',12);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'на турнире школы танца "Итоговый кубок SPORTDANCE"'),0,1,'C'); 
 $pdf->Ln(20); 
   $pdf->SetFont('Arial','',12);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'главный судья: Щукина Анна'),0,1,'C'); 
 $pdf->Ln(10);    $pdf->SetFont('Arial','',12);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'13.05.2018'),0,1,'C');
            
            /*
            
		echo '<div class="" style="height: 150px;"> </div>';
		echo '<div class="diplom1" style="height: 110px;">'.$diplom['name'].'</div>';
		echo '<div class="diplom2" style="height: 90px;">'.$diplom['place'].'</div>';
		echo '<div class="diplom2" style="height: 90px;">'.$Competition->shortname.'</div>';
		echo '<div class="diplom3" style="height: 90px;">'.$programname.'</div>';
		echo '<div class="diplom3" style="height: 175px;">'.$agename.'</div>';
		echo '<div class="diplom4" style="height: 75px;">'.$Competition->org.'<span style="width: 150px; display:inline-block;"></span>'.$Competition->chief.'</div>';
		echo '<div class="diplom4" style="height: 200px;"><img src="/img/signature.gif" /><span style="width: 150px; display:inline-block;"></span><span style="width: 150px; display:inline-block;"></span></div>';
		echo '<div class="diplom4" style="height: 50px;">'.$Competition->data.' г. Москва</div>';
		echo '</div>';*/
	} 
		
	
	
?>