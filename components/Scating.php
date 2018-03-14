<?php
namespace app\components;
/* класс Scating - вычисления мест (Скейтинг система)
 * Версия: 1.0 alfa
 * Автор: Volod
 * Ввод: массив мест проставленных судьями за танцы
 * Вывод: массив мест за каждый танец и итог за финал 
 * 
 * Пример использования:
 * 
 * include_once 'Scating.php';
 * //масив судейских оценок(мест)
 * $JudicialPlaces=[1=>//танец
 *  				[11=>//пара
 *  					[3,3,3,2,3],//судьи
 *  				2=>
 *  					[6,6,6,6,5],
 *  				3=>
 *  					[2,2,5,4,1],
 *  				4=>
 *  					[4,4,2,3,4],
 *  				5=>
 *  					[1,5,1,1,2],
 *  				6=>
 *  					[5,1,4,5,6],
 *  				],
 *  			2=>//танец
 *  				[11=>//пара
 *  					[1,5,1,1,2],//судьи
 *  				2=>
 *  					[2,2,5,4,1],
 *  				3=>
 *  					[3,3,3,2,3],
 *  				4=>
 *  					[4,4,2,3,4],
 *  				5=>
 *  					[5,1,4,5,5],
 *  				6=>
 *  					[6,6,6,6,6],
 *  				],
 *  			3=>//танец
 *  				[11=>//пара
 *  					[1,1,1,4,4],//судьи
 *  				2=>
 *  					[3,2,2,1,1],
 *  				3=>
 *  					[2,5,5,2,2],
 *  				4=>
 *  					[4,3,4,5,3],
 *  				5=>
 *  					[5,4,3,3,5],
 *  				6=>
 *  					[6,6,6,6,6],
 *  				],
 *  			4=>//танец
 *  				[11=>//пара
 *  					[1,1,1,4,4],//судьи
 *  				2=>
 *  					[3,2,2,1,1],
 *  				3=>
 *  					[2,5,5,2,2],
 *  				4=>
 *  					[4,3,4,5,3],
 *  				5=>
 *  					[5,4,3,3,5],
 *  				6=>
 *  					[6,6,6,6,6],
 *  				],
 *  			5=>//танец
 *  				[11=>//пара
 *  					[1,1,1,4,4],//судьи
 *  				2=>
 *  					[3,2,2,1,1],
 *  				3=>
 *  					[2,5,5,2,2],
 *  				4=>
 *  					[4,3,4,5,3],
 *  				5=>
 *  					[5,4,3,3,5],
 *  				6=>
 *  					[6,6,6,6,6],
 *  				],
 * 
 *  			];
 * 			
 * 		$scating = new Scating($JudicialPlaces);//расчет мест
 * 		
 * 		$scating->rezult(); //итоги
 * 		//array(6) { 
 * 		//	[1]=> array(6) { [11]=> int(3) [2]=> int(6) [3]=> int(2) [4]=> int(4) [5]=> int(1) [6]=> int(5) } //места за 1 танцец
 * 		//	[2]=> array(6) { [11]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) } 
 * 		//	[3]=> array(6) { [11]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) } 
 * 		//	[4]=> array(6) { [11]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) } 
 * 		//	[5]=> array(6) { [11]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) } 
 * 		//	[0]=> array(6) { [11]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) } //итоговые места
 * 		//}		
 * 
 * 		$scating->log; //отладочная информация
 * 
 *  */
 	
class Scating
{ 	
	private $krest=[];//оценки судий
	private $coupls=[];//пары
	private $judges=[];//судьи
	private $judges_count=0;//кол. судий
	private $mark=[];//количество мест 
	private $coupleplase=[];//итоговые места
	private $dances=[];//танцы
    private $curentmark=1;//текущее место
    private $mark2=[];
    private $j=0;
	public $rezults=[];//результаты
	public $rezultsItog=[];//результаты итоговые
	public $log='';//отладочная информация
	
	private function log($log)
	{
		$this->log.=$log;
	}
	public function rezult()
	{
		return $this->coupleplase;
	}
	
 	public function __construct($krest)
	{
		//заполнения массивов dances,coupls,judges,mark на основе krest
		$this->krest = $krest;
		foreach ($this->krest as $dkey => $value1) {
			$this->dances[$dkey]=$dkey;
			foreach ($value1 as $couplekey => $value2) {
				$this->coupls[$couplekey]=$couplekey;	
				foreach ($value2 as $jkey => $value3) {
					$this->	judges[$jkey] =	$jkey;
					if (isset($this->mark[$dkey][$couplekey][$value3])) {$this->mark[$dkey][$couplekey][$value3]++;} else {
						{$this->mark[$dkey][$couplekey][$value3]=1;}
	}}}}
	
	$this->judges_count=count($this->judges); //кол. судей

	foreach ($this->dances as $keyd => $valued) { //расчет результатов за каждый танец
	
		$this->log ('Dance# '.$valued.'<br>');
		$this->log('<table><tr><td></td>');
		foreach ($this->judges as $key => $value) {
			$this->log('<td>'.$value.'</td>');
		}
		$this->log('</tr>');
		foreach ($this->coupls as $key => $value) {
			$this->log('<tr><td>'.$key.'</td>');
			foreach ($this->judges as $key_j => $value_j) {
				$this->log('<td><input type="text" name="krest'.$keyd.'_'.$value.'_'.$key_j.'" value="');
				if (isset($this->krest[$keyd][$value][$key_j])) {$this->log($this->krest[$keyd][$value][$key_j]);};
				$this->log('" size="2"></td>');
			}
		$this->log('</tr>');
						
								}
		$this->log('</table><br>');
		$this->log('<table border="1"><tr><td>Пары</td>');
		$this->j=0;
		foreach ($this->coupls as $key => $value) {
			$this->j++;
			$this->log('<td width="30px">'.$this->j.'</td>');
		}	
		$this->log('</tr>');
		foreach ($this->coupls as $key => $value) {
			$this->coupleplase[$keyd][$value]=0;
			$this->log('<tr><td>'.$key.'</td>');
			$mark_summ=0;
			for ($i=1; $i <=$this->j ; $i++) {
				if (isset($this->mark[$keyd][$value][$i])) $mark_summ=$mark_summ+ $this->mark[$keyd][$value][$i];
				$this->log('<td>'.$mark_summ.'</td>');
				$this->mark2[$value][$i]=$mark_summ;
			}	
			$this->log('</tr>');
		}	
		$this->log('</table><br>');
		$this->curentmark=1;
		$judges_most=ceil($this->judges_count/1.99);
		for ($i=1; $i <=$this->j ; $i++) {	
			$curentcouple=array();	
			foreach ($this->coupls as $key => $value) {	
				if ($this->mark2[$value][$i]>=$judges_most && !$this->coupleplase[$keyd][$value])	
					{
						$curentcouple[]=$value;		

					}
			}	
			while (!empty($curentcouple)) {
				$this->skayting($curentcouple,$i,$keyd);
				foreach ($curentcouple as $key3 => $value3) {
					if ($this->coupleplase[$keyd][$value3]!=0) {unset($curentcouple[$key3]);}
				}

			}

		}	

		$this->log('<table><tr><td>Пары</td><td>Места</td></tr>');
		foreach ($this->coupls as $key => $value) {
			$this->log('<tr><td>'.$key.'</td><td>'.$this->coupleplase[$keyd][$value].'</td></tr>');
			$this->rezults[$valued][$key]=$this->coupleplase[$keyd][$value];
		}	
		$this->log('</table><br>');
	
	}

	$this->log('Итог:<br><table border="1"><tr><td>Пары</td>');
	$count_dance=0;
	foreach ($this->dances as $key => $value) {
		$count_dance++;
$this->log('<td>танец #'.$value.'</td>');
}	
	$sum_mark_dance=array();
	$this->log('<td>Сумма</td></tr>');
foreach ($this->coupls as $key => $value) {
$this->log('<tr><td>'.$key.'</td>');
	$sum_mark_dance[$key]=0;
	foreach ($this->dances as $key1 => $value2) {
$this->log('<td>'.$this->coupleplase[$key1][$value].'</td>');
		$sum_mark_dance[$key]=$sum_mark_dance[$key]+$this->coupleplase[$key1][$value];
}

$this->log('<td>'.$sum_mark_dance[$key].'</td></tr>');
}	
	$this->log('</table><br>');
	$coupls2=$this->coupls;
	foreach ($this->coupls as $key => $value) {$this->coupleplase[0][$value]=0;};
for ($i=1; $i <count($this->coupls)+1 ; $i++) {
	$summin=9999999999999999999;
	
	foreach ($coupls2 as $key => $value) {
	if	($sum_mark_dance[$key]==$summin) {$coupl_sum_min[$key]=$value;};
	if	($sum_mark_dance[$key]<$summin) {$coupl_sum_min=array();$summin=$sum_mark_dance[$key]; $coupl_sum_min[$key]=$value;}
	}
	
	if (count($coupl_sum_min)==1) {foreach ($coupl_sum_min as $key => $value) {$this->coupleplase[0][$value]=$i; unset($coupls2[$key]); }}
	if (count($coupl_sum_min)>1) {

		$rule10=array();
		$couple_r10=array();
		$rule10maxcount=0;
		$rule10minsum=99999999999999999999999;
	foreach ($coupl_sum_min as $key => $value) {
		$rule10[$key]['sum']=0;
		$rule10[$key]['count']=0;
	foreach ($this->dances as $key1 => $value1) {	
	if (ceil($this->coupleplase[$key1][$value])<=$i) {$rule10[$key]['count']++;$rule10[$key]['sum']=$rule10[$key]['sum']+$this->coupleplase[$key1][$value];}	
	}	

	if ($rule10[$key]['count']==$rule10maxcount) {if ($rule10[$key]['sum']<$rule10minsum) {$couple_r10=array();$couple_r10[$key]=$value;$rule10minsum=$rule10[$key]['sum'];}
	                                              if ($rule10[$key]['sum']==$rule10minsum) {$couple_r10[$key]=$value;}
	
	                                             }
	
	if ($rule10[$key]['count']>$rule10maxcount) {
		$couple_r10=array();
		$couple_r10[$key]=$value;
		$rule10maxcount=$rule10[$key]['count'];
		$rule10minsum=$rule10[$key]['sum'];}
	} 

	if (count($couple_r10)==1) {foreach ($couple_r10 as $key => $value) {$this->coupleplase[0][$value]=$i; unset($coupls2[$key]); }}
	
	if (count($couple_r10)>1) {
			
		foreach ($couple_r10 as $key => $value) {
			foreach ($this->dances as $key1 => $value1) {
				foreach ($this->mark[$key1][$value] as $key2 => $value2) {
					if (isset($this->mark[0][$value][$key2])) {	$this->mark[0][$value][$key2]=$this->mark[0][$value][$key2]+$value2;} else 
						{$this->mark[0][$value][$key2]=$value2;}
				}}}
				
			


foreach ($couple_r10  as $key => $value) {
$mark_summ=0;
for ($n=1; $n <=$this->j ; $n++) {
	if (isset($this->mark[0][$value][$n])) $mark_summ=$mark_summ+ $this->mark[0][$value][$n];
	$this->mark2[$value][$n]=$mark_summ;
}}	
	



	$this->curentmark=$i;
	$m=$i;
	$judges_most=ceil($this->judges_count*$count_dance/1.99);
$curentcouple=array();	
do {

	
foreach ($couple_r10 as $key => $value) {	
if ($this->mark2[$value][$m]>=$judges_most)
{
$curentcouple[$key]=$value;		

}
}	
if (!empty($curentcouple)) {
$this->skayting2($curentcouple,$m,0);

	foreach ($curentcouple as $key3 => $value3) {

if ($this->coupleplase[0][$value3]!=0) {  unset($coupls2[$key3]); 

	}
};break(1);
} else {$m++;}

} while (1);


		
	};
	
	

}
}
$this->log('<table><tr><td>Пары</td><td>Места по всем танцам</td></tr>');
foreach ($this->coupls as $key => $value) {
$this->log('<tr><td>'.$key.'</td><td>'.$this->coupleplase[0][$value].'</td></tr>');
	$this->rezultsItog[$key]=$this->coupleplase[0][$value];
}	
$this->log('</table>');

	
 
 



 	

 	
	}
		
		
		
	private function skayting($curentcouple,$i,$r3)
	{
		
	if ($i>$this->j) {
		$sum=0;
		for ($v=$this->curentmark; $v < $this->curentmark+count($curentcouple); $v++) {$sum=$sum+$v;}
		$sum=$sum/count($curentcouple);
		foreach ($curentcouple as $key3 => $value3) {
		$this->coupleplase[$r3][$value3]=$sum;
		};
		$this->curentmark=$this->curentmark+count($curentcouple);
		return;
	}	
	$topmark=0;
	$topcouple=array();
	
	foreach ($curentcouple as $key3 => $value3) {
	if ($this->mark2[$value3][$i]==$topmark) {$topcouple[]=$value3;};
	if ($this->mark2[$value3][$i]>$topmark) {$topmark=$this->mark2[$value3][$i];$topcouple=array($value3);};
}	
	
if (count($topcouple)>1) {
	
	$lowsum=999999999999;
	$lowsumcouple=array();
	foreach ($topcouple as $ke4 => $value4) {
		$curentcouplesumme=0;	
for ($k=1; $k <=$i ; $k++) {
if (isset($this->mark[$r3][$value4][$k]))	{$curentcouplesumme=$curentcouplesumme+$this->mark[$r3][$value4][$k]*$k;}
}
if ($curentcouplesumme==$lowsum)	{ $lowsumcouple[]=$value4;};
if ($curentcouplesumme<$lowsum)	{$lowsum=$curentcouplesumme; $lowsumcouple=array($value4);};
}
if (count($lowsumcouple)>1) {
	$this->skayting($lowsumcouple,$i+1,$r3);
} else {$this->coupleplase[$r3][$lowsumcouple[0]]=$this->curentmark;$this->curentmark++;};	
		
}

else {	
$this->coupleplase[$r3][$topcouple[0]]=$this->curentmark;$this->curentmark++;
}
		
}///function skayting
	
	
	
	
	private function skayting2($curentcouple,$i,$r3)
	{ 
	if ($i>$this->j) {
		$sum=0;
		for ($v=$this->curentmark; $v < $this->curentmark+count($curentcouple); $v++) {$sum=$sum+$v;}
		$sum=$sum/count($curentcouple);
		foreach ($curentcouple as $key3 => $value3) {
		$this->coupleplase[$r3][$value3]=$sum;
		};
		$this->curentmark=$this->curentmark+count($curentcouple);
		return;
	}	
	$topmark=0;
	$topcouple=array();
	
	foreach ($curentcouple as $key3 => $value3) {
	if ($this->mark2[$value3][$i]==$topmark) {$topcouple[]=$value3;};
	if ($this->mark2[$value3][$i]>$topmark) {$topmark=$this->mark2[$value3][$i];$topcouple=array($value3);};
}	
	
if (count($topcouple)>1) {
	
	$lowsum=999999999999;
	$lowsumcouple=array();
	foreach ($topcouple as $ke4 => $value4) {
		$curentcouplesumme=0;	
for ($k=1; $k <=$i ; $k++) {
if (isset($this->mark[$r3][$value4][$k]))	{$curentcouplesumme=$curentcouplesumme+$this->mark[$r3][$value4][$k]*$k;}
}
if ($curentcouplesumme==$lowsum)	{ $lowsumcouple[]=$value4;};
if ($curentcouplesumme<$lowsum)	{$lowsum=$curentcouplesumme; $lowsumcouple=array($value4);};
}
if (count($lowsumcouple)>1) {
	$this->skayting2($lowsumcouple,$i+1,$r3);
} else {$this->coupleplase[$r3][$lowsumcouple[0]]=$this->curentmark;$this->curentmark++;};	
		
}

else {	
$this->coupleplase[$r3][$topcouple[0]]=$this->curentmark;$this->curentmark++;
}
}///function skayting2	
}