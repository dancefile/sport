<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$heatsArr=$turInfo->getHeats();

$inArr=$turInfo->getIn();
$countCouple=count($inArr);
$ParNextTur=$turInfo->gettur('ParNextTur');
$arrDance=$turInfo->getDances();
foreach ($arrDance as $keyDance => $dance){
	$arr[$keyDance][0]=$inArr;
}


		foreach ($heatsArr as $idcouple => $value1) {
			foreach ($value1 as $iddance => $zahod) {
				
				if ($iddance==0) {
				foreach ($arrDance as $keyDance => $dance){
					unset($arr[$keyDance][0][$idcouple]);
				$arr[$keyDance][$zahod][$idcouple]=$inArr[$idcouple];				
				}} else {
					unset($arr[$iddance][0][$idcouple]);
					$arr[$iddance][$zahod][$idcouple]=$inArr[$idcouple];
				}
				
				}
		}


	
$begunArr=[];//массив хранит все танцы, все судьи, все заходы, номера пар.
foreach ($arrDance as $idDance => $dance){
$begunArr[$idDance]=['name'=>$dance,'zahod'=>[]];
for ($i=1; $i <= $turInfo->gettur('zahodcount'); $i++) {
    $begunArr[$idDance]['zahod'][$i]['name']='Заход '.$i;
	
	//if ($prosmotr) $data['p'.$i]['heats']='просмотр';
	//if ($pole) $data['s'.$i]['heats']=$polename;

}

	foreach ($arr[$idDance] as $zahod => $value1) {
		if (count($value1)) {
				asort($value1);
			foreach ($value1 as $idcouple => $nomer) {
                                $begunArr[$idDance]['zahod'][$zahod]['couple'][]=$nomer;
		//		if ($pole) $data['s'.$zahod]['c'.$i]='';
		//		if ($prosmotr) $data['p'.$zahod]['c'.$i]='';
			}
		}
	}

   
foreach ($judge as $judgeId => $judgeName) {
    $begunArr[$idDance]['judge'][$judgeId]=$judgeName;
}
}
$pdf->SetMargins(5,5,5);
$pdf->SetAutoPageBreak('On',5);

do {
foreach ($begunArr as $idDance => &$arrDancce)
{

     if (count($arrDancce['judge'])!=0) {
        $pdf->AddPage();

        
   foreach ($arrDancce['judge'] as $judgeId => &$judgeName) {
       $tmpint=count($arrDancce['zahod'])*7;
       if ($pole)  $tmpint=$tmpint*2;
       
       if ($pdf->GetY()+10+$tmpint+10>290) {unset($judgeName); break;}
        $pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$turInfo->gettur('id').'. '.$turInfo->gettur('name').' '.$turInfo->gettur('turname')),0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$Competition->name.' '.$Competition->data),0,1,'R'); 
        $pdf->Ln(5);      
        if ($ParNextTur) $tempstr=' => '.$ParNextTur; else $tempstr='';
        $pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$arrDancce['name'].'     '. $judgeName.' ______________       '.'пар '.$countCouple.$tempstr),0,1,'L'); 
        $pdf->Ln(5);
       // $pdf->SetFillColor(235,235,235);
        
        foreach ( $arrDancce['zahod'] as $idzahod => $zahodArr) {
            $pdf->SetFont('Arial','',11);
             if ($pole)  { $border='LTR';} else {$border=1;};
            $pdf->Cell(17,7,iconv("UTF-8","Windows-1251",$zahodArr['name']),$border,0,'C');
            $pdf->SetFont('Arial','',15);
            
            foreach ( $zahodArr['couple'] as $nomer) {
                $pdf->Cell(12,7,iconv("UTF-8","Windows-1251",$nomer),$border,0,'C');
             }
             if ($pole)  {
                 $pdf->Ln(7);
                  $pdf->Cell(17,7,iconv("UTF-8","Windows-1251",' '),'LRB',0,'C');
                 foreach ( $zahodArr['couple'] as $nomer) {
                $pdf->Cell(12,7,iconv("UTF-8","Windows-1251",' '),'LRB',0,'C');
             }}
            $pdf->Ln(7); 
        }
        $pdf->Ln(10); 
        
        
        
        unset($arrDancce['judge'][$judgeId]);
   }
   //if (count($arrDancce['judge'])==0) {
   //unset ($arrDancce);//unset ($begunArr[$idDance]);}
     } else {unset ($begunArr[$idDance]);};
}
} while (count($begunArr)!=0);


 ?>
