<?php
namespace app\models\volod;

use yii\data\ArrayDataProvider;
use yii\helpers\Html;

class TurInfo extends \yii\base\Object
{
    private	$tur=null;
    private	$arrDance=null;
    private	$inArr=null;
    private	$inArrMore=null;	
    private	$heatsArr=null;
    private	$names=null;	
    private	$dancerClub=null;
    private	$dancerTreners=null;
    private     $zahodDancerArr=null;
    
    
        public function heatProvider($idDance)
    {
    
    $data=[];

for ($i=1; $i <= $this->gettur('zahodcount'); $i++) {
	$data[$i]['heats']='Заход '.$i;
}


	foreach ($this->zahodDancerArr[$idDance] as $zahod => $value1) {
		if (count($value1)) {
				asort($value1);
				$data[$zahod]['heats']='Заход '.$zahod;
				$data[$zahod]['couple']=implode($value1, ', ');			
			}}
		
        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => 
        	[
            	'pageSize' =>  false,
        	],

    ]);
    
    
}
    
     public function SetZahodDancerArr($arrDance)
    {   
      foreach ($arrDance as $keyDance => $dance){
	$this->zahodDancerArr[$keyDance][0]=$this->getIn();
}


		foreach ($this->getHeats() as $idcouple => $value1) {
			foreach ($value1 as $iddance => $zahod) {
				unset($this->zahodDancerArr[$iddance][0][$idcouple]);
				$this->zahodDancerArr[$iddance][$zahod][$idcouple]=$this->getIn()[$idcouple];				
			}
		}   
         

    }

    public function search($params,$arrDance)
    {
    
        $data=[];
        $heatsArr=$this->getHeats();
        $inArr=$this->getIn();
	asort($inArr);
	 
    foreach ($inArr as $key => $nomer): 
    	$data[$key] = [	'nomer' => $nomer,
    					'name'=>$this->GetCoupleName($key),
    					'club'=>$this->GetCoupleName($key,'clubName'),
    					'City'=>$this->GetCoupleCity($key),
    					'Trener'=>$this->GetCoupleTrener($key),
    					
    					];
	if (is_array($arrDance)) foreach ($arrDance as $key1 => $dance) {
		if (isset($heatsArr[$key][$key1])) {
				$data[$key]['id'.$key1]=Html::a($heatsArr[$key][$key1],NULL, ['class' => 'setheats nomer','id' =>$nomer.'_'.$key1]);			
		} else $data[$key]['id'.$key1]=Html::a('+',NULL, ['class' => 'setheats nomer','id' =>$nomer.'_'.$key1]);
	}
    endforeach;

    $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => 
        	[
            	'pageSize' => false,
        	],

    ]);
     
    return $provider;
    }
    
    
    

	public function GetCoupleTrener($inId,$seporate='<br>')
	{
		if ($this->dancerTreners===null) {$this->loadDancerInfo();}
		$trenerCouple=[];
		if (isset($this->inArrMore[$inId]['dancer1']) && isset($this->dancerTreners[$this->inArrMore[$inId]['dancer1']])) {
			foreach ($this->dancerTreners[$this->inArrMore[$inId]['dancer1']] as $value) {if (array_search($value, $trenerCouple)===FALSE) $trenerCouple[]=$value;}
		}
		if (isset($this->inArrMore[$inId]['dancer2']) && isset($this->dancerTreners[$this->inArrMore[$inId]['dancer2']])) {
			foreach ($this->dancerTreners[$this->inArrMore[$inId]['dancer2']] as $value) {if (array_search($value, $trenerCouple)===FALSE) $trenerCouple[]=$value;}
		}
		return implode($trenerCouple, $seporate);
	}



	public function loadDancerInfo()
	{
		if ($this->names===null) $this->loadNames();
		$ids=[];
		foreach ($this->names as $value) {
			if (isset($value['clubId']) && $value['clubId'] && array_search($value['clubId'], $ids)===FALSE) $ids[]=$value['clubId']; 
		}
		$this->dancerClub=[];
		$clubs = (new \yii\db\Query()) 
    		->select(['club.id','cityName'=>'city.name','countryName'=>'country.name'])
			->from('club')
			->leftJoin('city','club.city_id=city.id')
			->leftJoin('country','city.country_id=country.id')
        	->where(['in', 'club.id',$ids]);
            foreach ($clubs->each() as $row) {
				$this->dancerClub[$row['id']]['cityName']=$row['cityName'];
				$this->dancerClub[$row['id']]['countryName']=$row['countryName'];
			}
					
		$ids=array_keys($this->names);
		$this->dancerTreners=[];
		$treners = (new \yii\db\Query()) 
    		->select(['dancer_trener.dancer_id','trener.name','trener.sname'])
			->from('dancer_trener')
			->leftJoin('trener','dancer_trener.trener_id=trener.id')
        	->where(['in', 'dancer_trener.dancer_id',$ids]);
            foreach ($treners->each() as $row) {
				$this->dancerTreners[$row['dancer_id']][]=$row['sname'].' '.$row['name'];
			}
				
		
	}

	public function GetCoupleCity($inId,$info='cityName',$seporate='<br>')
	{

		if ($this->dancerClub===null) {$this->loadDancerInfo();}
			$CoupleInfo=[];
		if (isset($this->inArrMore[$inId]['dancer1']) && isset($this->names[$this->inArrMore[$inId]['dancer1']]['clubId'])) 
		{
			if (isset($this->dancerClub[$this->names[$this->inArrMore[$inId]['dancer1']]['clubId']][$info]))	$CoupleInfo[]=$this->dancerClub[$this->names[$this->inArrMore[$inId]['dancer1']]['clubId']][$info];
		}
		if (isset($this->inArrMore[$inId]['dancer2']) && isset($this->names[$this->inArrMore[$inId]['dancer2']]['clubId'])) {
			if (isset($this->dancerClub[$this->names[$this->inArrMore[$inId]['dancer2']]['clubId']][$info]))	
			$CoupleInfo[]=$this->dancerClub[$this->names[$this->inArrMore[$inId]['dancer2']]['clubId']][$info];
		}		
		return implode($CoupleInfo, $seporate);	
	}

	public function loadNames()
	{
		if ($this->inArr===null) $this->getIn();
		$ids=[];
		foreach ($this->inArrMore as $value) {
			if(isset($value['dancer1']) && array_search($value['dancer1'], $ids)===FALSE) $ids[]=$value['dancer1'];
			if(isset($value['dancer2']) && array_search($value['dancer2'], $ids)===FALSE) $ids[]=$value['dancer2'];
		}
	
	$dancers = (new \yii\db\Query()) 
    	->select(['dancer.name','dancer.id','dancer.sname','clubName'=>'club.name','clubId'=>'dancer.club','clasLaName'=>'clasLa.name','clasStname'=>'clasSt.name'])
		->from('dancer')
		->leftJoin('club','dancer.club=club.id')
		->leftJoin('clas as clasLa','dancer.clas_id_st=clasLa.id')
		->leftJoin('clas as clasSt','dancer.clas_id_la=clasSt.id')
        ->where(['in', 'dancer.id',$ids]);
            foreach ($dancers->each() as $row) {
				$this->names[$row['id']]['fname']=$row['sname'].' '.$row['name'];
				$this->names[$row['id']]['clubName']=$row['clubName'];
				$this->names[$row['id']]['clubId']=$row['clubId'];
				$this->names[$row['id']]['clasStname']=$row['clasStname'];
				$this->names[$row['id']]['clasLaName']=$row['clasLaName'];
			}
	}

	public function GetCoupleName($inId,$info='fname',$seporate='<br>')
	{
		if ($this->names===null) {$this->loadNames();}
		$nameCouple=[];
		if (isset($this->inArrMore[$inId]['dancer1']) && isset($this->names[$this->inArrMore[$inId]['dancer1']][$info])) {$nameCouple[]=$this->names[$this->inArrMore[$inId]['dancer1']][$info];}
		if (isset($this->inArrMore[$inId]['dancer2']) && isset($this->names[$this->inArrMore[$inId]['dancer2']][$info])) {$nameCouple[]=$this->names[$this->inArrMore[$inId]['dancer2']][$info];}
		return implode($nameCouple, $seporate);
	}
	
	
	public function setTur($idT=0) 
	{
     $this->tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['idT'=>'tur.id','category.id','turname'=>'tur.name','tur.typezahod','category.dancing_order','tur.typezahod','tur.dances','tur.ParNextTur','category.name','tur.typeSkating','tur.zahodcount'])
                ->from('tur')
		->innerJoin('category','tur.category_id=category.id')
		->where(['tur.id'=>$idT])
		->one();		
	 $this->arrDance=null;
	 $this->inArr=null;
	}
	
	public function getTur($name) {
		if (isset($this->tur[$name])) return $this->tur[$name]; else return FALSE;
	}
	
	public function getDances() {
		if ($this->arrDance===null) {
		$this->arrDance = array_fill_keys(explode(',',str_replace(' ','',$this->tur['dances'])), '');
        $Dance = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
                ->from('dance')
                ->where(['in', 'id',array_keys($this->arrDance)]);	
        foreach ($Dance->each() as $row) {
           if (isset($this->arrDance[$row['id']])) $this->arrDance[$row['id']]=$row['name']; 
        }}
		return $this->arrDance;
	}
	
	public function getIn() {
		if ($this->inArr===null) {
			$this->inArr=[];           
            $in = (new \yii\db\Query()) //получаем список пар  за текущей тур
            	->select(['in.id','in.nomer','in.who','couple.dancer_id_1','couple.dancer_id_2'])
	    		->from('in')
				->innerJoin('couple','in.couple_id=couple.id')
                ->where(['tur_id' => $this->tur['idT']]);	
            foreach ($in->each() as $row) {
				$this->inArr[$row['id']]=$row['nomer'];	
				switch ($row['who']) {
					case '1':
						$this->inArrMore[$row['id']]['dancer1']=$row['dancer_id_1'];
					break;
					case '2':
						$this->inArrMore[$row['id']]['dancer2']=$row['dancer_id_2'];
					break;
					default:
						$this->inArrMore[$row['id']]['dancer1']=$row['dancer_id_1']; $this->inArrMore[$row['id']]['dancer2']=$row['dancer_id_2'];
					break;
				
			}
				$this->inArr[$row['id']]=$row['nomer'];
            }
			}
		return $this->inArr;
		}
	
	
		public function getHeats() {
		if ($this->heatsArr===null) {
			if ($this->inArr===null) $this->getIn();
	        $this->heatsArr=[];
            $heats = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
                ->from('in_dance')
                ->where(['in', 'id_in',array_keys($this->inArr)]);	
            foreach ($heats->each() as $row) {
                if (!$row['dance_id']) $row['dance_id']=0;	
                $this->heatsArr[$row['id_in']][$row['dance_id']]=$row['zahod'];	
            }
	
			}
		return $this->heatsArr;
		}
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
}
	