<?php

namespace app\models\volod;

class TurInfo extends \yii\base\Object
{
	private	$tur=null;
	private	$arrDance=null;
	private	$inArr=null;
	private	$inArrMore=null;	
	private	$heatsArr=null;
	private	$names=null;	


	public function loadNames()
	{
		$ids=[];
		foreach ($this->inArrMore as $value) {
			if(isset($value['dancer1']) && array_search($value['dancer1'], $ids)===FALSE) $ids[]=$value['dancer1'];
			if(isset($value['dancer2']) && array_search($value['dancer2'], $ids)===FALSE) $ids[]=$value['dancer2'];
		}
	
	$dancers = (new \yii\db\Query()) 
    	->select(['dancer.name','dancer.id','dancer.sname','clubName'=>'club.name','clasLaName'=>'clasLa.name','clasStname'=>'clasSt.name'])
		->from('dancer')
		->leftJoin('club','dancer.club=club.id')
		->leftJoin('clas as clasLa','dancer.clas_id_st=clasLa.id')
		->leftJoin('clas as clasSt','dancer.clas_id_la=clasSt.id')
		//->leftJoin('city','city_id=city.id')
        ->where(['in', 'dancer.id',$ids]);
            foreach ($dancers->each() as $row) {
				$this->names[$row['id']]=$row['sname'].' '.$row['sname'];
			}
	}

	public function GetNameCouple($inId)
	{
		if ($this->names===null) {$this->loadNames();}
		$nameCouple=[];
		if (isset($this->inArrMore[$inId]['dancer1']) && isset($this->names[$this->inArrMore[$inId]['dancer1']])) {$nameCouple[]=$this->names[$this->inArrMore[$inId]['dancer1']];}
		if (isset($this->inArrMore[$inId]['dancer2']) && isset($this->names[$this->inArrMore[$inId]['dancer2']])) {$nameCouple[]=$this->names[$this->inArrMore[$inId]['dancer2']];}
		return implode($nameCouple, ', ');
	}
	
	
	public function setTur($idT=0) 
	{
     $this->tur = (new \yii\db\Query()) //получаем инфу о данном туре и категории
		->select(['idT'=>'tur.id','category.id','turname'=>'tur.name','tur.typezahod','tur.typezahod','tur.dances','category.name'])
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
				$this->inArr[$row['id']]=$row['nomer'];;
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
	