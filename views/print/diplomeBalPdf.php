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
$pdf->Cell(12,7,iconv("UTF-8","Windows-1251",'№'),1,0,'C');
$pdf->Cell(100,7,iconv("UTF-8","Windows-1251",'Участники'),1,0,'C');
$pdf->Cell(40,7,iconv("UTF-8","Windows-1251",'Клуб'),1,0,'C');
$pdf->Cell(30,7,iconv("UTF-8","Windows-1251",'Город'),1,0,'C');
$pdf->Cell(60,7,iconv("UTF-8","Windows-1251",'Тренеры'),1,0,'C');
$pdf->Cell(20,7,iconv("UTF-8","Windows-1251",'Диплом'),1,0,'C');
$pdf->Cell(20,7,iconv("UTF-8","Windows-1251",'Балы'),1,0,'C');
$pdf->Ln(7);
$pdf->SetFont('Arial','',10);

	$inArr=$turInfo->getIn();

$countDiploms=[1=>0,2=>0,3=>0];
	$diploms=[];
    foreach ($resultCouple as $nomer => $result){
    	$key = array_search($nomer, $inArr);
		$names=$turInfo->GetCoupleName($key,'fname','-');
		$diplom=['name'=>$names,'bals'=>$result['bal'],'place'=>' Диплом '.$result['stepen']. ' степени. ' ];
		$diploms[]=$diplom;
		$countDiploms[$result['stepen']]++;		
		if (strripos($names,'-')!==false) {
		$diploms[]=$diplom;
		$countDiploms[$result['stepen']]++;		
		} 
		
                
                $pdf->Cell(12,7,iconv("UTF-8","Windows-1251",$nomer),1,0,'C');
$pdf->Cell(100,7,iconv("UTF-8","Windows-1251",$names),1,0,'L');
$pdf->Cell(40,7,iconv("UTF-8","Windows-1251",$turInfo->GetCoupleName($key,'clubName')),1,0,'C');
$pdf->Cell(30,7,iconv("UTF-8","Windows-1251",$turInfo->GetCoupleCity($key)),1,0,'C');
$pdf->Cell(60,7,iconv("UTF-8","Windows-1251",$turInfo->GetCoupleTrener($key,',')),1,0,'C');
$pdf->Cell(20,7,iconv("UTF-8","Windows-1251",$result['stepen']. ' степень'),1,0,'C');
$pdf->Cell(20,7,iconv("UTF-8","Windows-1251",$result['bal']),1,0,'C');
   $pdf->Ln(7);             
                
                
    	$data[$nomer] = [	'nomer' => $nomer,
    					'name'=>$names,
    					'club'=>$turInfo->GetCoupleName($key,'clubName'),
    					'City'=>$turInfo->GetCoupleCity($key),
    					'Trener'=>$turInfo->GetCoupleTrener($key),
    					'diplom'=>$result['stepen']. ' степень',
    					'bals'=>$result['bal'],
    					];
						
	}
	
/*foreach ($countDiploms as $key => $value) {
echo 'Степень: '.$key.' кол: '.$value.'.<br>';	
}*/

foreach ($diploms as $key=>$diplom) {

$pdf->AddPage('P','A4');	
	
 $pdf->Ln(150);
 $pdf->SetFont('Arial','',22);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'НАГРАЖДАЕТСЯ'),0,1,'C'); 
 $pdf->Ln(15); 
 $pdf->SetFont('Arial','',17);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$diplom['name']),0,1,'C'); 
 $pdf->Ln(10); 
  $pdf->SetFont('Arial','',12);
 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'результат:'),0,1,'C'); 
 $pdf->Ln(10); 
   $pdf->SetFont('Arial','',17);
   $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$diplom['bals'].' баллов'),0,1,'C'); 
 $pdf->Ln(10); 

 $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$diplom['place']),0,1,'C'); 
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

	} 
		
	
	
?>