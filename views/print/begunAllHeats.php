<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;


$heatsArr=$turInfo->getHeats();
	
$inArr=$turInfo->getIn();

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
/*
    $columns=[[
           	    'header' => 'танец',
               	'attribute' => 'dance',
               	'headerOptions' => ['class' =>'no-print','style' => ''],
               	'contentOptions' => ['class' =>'nomer1'],
    	       ],
				];
			for ($i=1; $i <16 ; $i++) { 
	$columns[]=[
           	    'header' => $i,
               	'attribute' => 'c'.$i,
               	'format' => 'raw',
               	'headerOptions' => ['class' =>'no-print','style' => ''],
               	'contentOptions' => ['class' =>'nomer'],
               	'options' => ['style' => 'width: 55px; max-width: 55px;'],
    	       ];			
			};
		*/
$begunArr=[];                
for ($zahod=1; $zahod <= $turInfo->gettur('zahodcount'); $zahod++) {
$begunArr[$zahod]=['dance'=>[],'couple'=>[]];	
foreach ($arrDance as $idDance => $dance){
 $begunArr[$zahod]['dance'][$idDance]['name']=$dance;
	//if ($prosmotr) $data['p'.$idDance]['dance']='просмотр';
	//if ($pole) $data['s'.$idDance]['dance']=$polename;

}

foreach ($arr as $iddance => $value1) {

		if (count($value1[$zahod])) {
				asort($value1[$zahod]);
			//$i=1;
			//var_dump($value1[$zahod]);
			foreach ($value1[$zahod] as $idcouple => $nomer) {
                           if (!in_array($nomer, $begunArr[$zahod]['couple'])) {
                                $begunArr[$zahod]['couple'][]=$nomer;
                            }
                               // $data[$iddance]['c'.$i]=$nomer;
                            //if ($pole) $data['s'.$iddance]['c'.$i]='';
			//	if ($prosmotr) $data['p'.$iddance]['c'.$i]='';
			//	$i++;
			}
		}
	
}
	
    /*$provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => 2000,
        	],

    ]);*/

foreach ($judge as $judgeId => $judgeName) {
    $begunArr[$zahod]['judge'][$judgeId]=$judgeName;
    /*
	echo '<div class="not-razriv otstup">';
	echo '<h3>'.Html::encode($turInfo->gettur('id').'. '.$turInfo->gettur('name').' '.$turInfo->gettur('turname')).'</h3>';
	echo '<div class="begunok">'.Html::encode('заход '.$zahod).'<span style="width: 100px; display:inline-block;"> </span>'.Html::encode($judgeName.' ______________');
	echo '<span style="width: 100px; display:inline-block;"> </span>';
	echo '</div>';
	echo '<div class="">'.Html::encode($Competition->name.' '.$Competition->data).'</div>';
	echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
	]);
	echo '</div>';
     * 
     */
}

//echo '</div>';
}
$pdf->SetMargins(5,5,5);
$pdf->SetAutoPageBreak('On',5);

do {
foreach ($begunArr as $ZahodNomer => &$Zahod)
{

     if (count($Zahod['judge'])!=0) {
        $pdf->AddPage();

        
   foreach ($Zahod['judge'] as $judgeId => &$judgeName) {
       $tmpint=count($Zahod['dance'])*7;
       if ($pole)  $tmpint=$tmpint*2;
       
       if ($pdf->GetY()+10+$tmpint+10>290) {unset($judgeName); break;}
        $pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$turInfo->gettur('id').'. '.$turInfo->gettur('name').' '.$turInfo->gettur('turname')),0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(0,0,iconv("UTF-8","Windows-1251",$Competition->name.' '.$Competition->data),0,1,'R'); 
        $pdf->Ln(5);      
        $pdf->SetFont('Arial','',12);
	$pdf->Cell(0,0,iconv("UTF-8","Windows-1251",'Заход '.$ZahodNomer.'     '. $judgeName.' ______________ '),0,1,'L'); 
        $pdf->Ln(5);
        
        foreach ( $Zahod['dance'] as $idDance => $DanceArr) {
            $pdf->SetFont('Arial','',11);
             if ($pole)  { $border='LTR';} else {$border=1;};
            $pdf->Cell(17,7,iconv("UTF-8","Windows-1251",$DanceArr['name']),$border,0,'C');
            $pdf->SetFont('Arial','',15);
            
            foreach ( $Zahod['couple'] as $nomer) {
                $pdf->Cell(12,7,iconv("UTF-8","Windows-1251",$nomer),$border,0,'C');
             }
             if ($pole)  {
                 $pdf->Ln(7);
                  $pdf->Cell(17,7,iconv("UTF-8","Windows-1251",' '),'LRB',0,'C');
                 foreach ( $Zahod['couple'] as $nomer) {
                $pdf->Cell(12,7,iconv("UTF-8","Windows-1251",' '),'LRB',0,'C');
             }}
            $pdf->Ln(7); 
        }
        $pdf->Ln(10); 
        
        
        
        unset($Zahod['judge'][$judgeId]);
   }
     } else {unset ($begunArr[$ZahodNomer]);};
}
} while (count($begunArr)!=0);

