<?php


namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
class Statistic
{
    
    public function getStatCity() {
        $query = new \yii\db\Query();        
        $query 
                ->select(['city', 'COUNT(*) count', 'order.id o_id'])
                ->from('couples')
                ->join('LEFT JOIN', 'order', 'order.couple_id=couples.id')
                ->where('order.id > 0')
                ->groupBy('city')
                ;
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }
    
    public function getStatClub() {
        
        $dancerArr=[];
        $query = new \yii\db\Query();  
        $query->select([
                    'in.couple_id couple_id', 
                    'in.id id',
                    'in.who who',
                    'couple.dancer_id_1 dancer_id_1',
                    'couple.dancer_id_2 dancer_id_2',
                    ])
        ->from('in')
        ->join('LEFT JOIN', 'tur', 'in.tur_id=tur.id')
        ->join('LEFT JOIN', 'couple', 'in.couple_id=couple.id')
                
        ->where(['tur.nomer'=>1]);
        foreach ($query->each() as $row) {
            switch ($row['who']){
                case 1:
                    if (isset($dancerArr[$row['dancer_id_1']])) {$dancerArr[$row['dancer_id_1']]++;} else {$dancerArr[$row['dancer_id_1']]=1;};
                    break;
                case 2:
                   if (isset($dancerArr[$row['dancer_id_2']])) {$dancerArr[$row['dancer_id_2']]++;} else {$dancerArr[$row['dancer_id_2']]=1;}; 
                    break;
                case 3:
                    if (isset($dancerArr[$row['dancer_id_1']])) {$dancerArr[$row['dancer_id_1']]++;} else {$dancerArr[$row['dancer_id_1']]=1;};
                    if (isset($dancerArr[$row['dancer_id_2']])) {$dancerArr[$row['dancer_id_2']]++;} else {$dancerArr[$row['dancer_id_2']]=1;};
                    break;
            }
  
        }
        
        $query = new \yii\db\Query(); 
        $query->select([
                    'dancer.id id',
                    'club.name club', 
                    'dancer.name name',
                    'dancer.sname sname',
                    ])
                ->from('dancer')
                ->join('LEFT JOIN', 'club', 'dancer.club=club.id')
                ->where(['in', 'dancer.id' ,array_keys($dancerArr)])
                ;

        $names=[];
        foreach ($query->each() as $row) {
        if (isset($names[$row['club']][$row['sname'].' '.$row['name']])) {
                $names[$row['club']][$row['sname'].' '.$row['name']]=$names[$row['club']][$row['sname'].' '.$row['name']]+$dancerArr[$row['id']];} 
            else {
               $names[$row['club']][$row['sname'].' '.$row['name']]=$dancerArr[$row['id']]; 
            }
            
        }
        
       $namesSum=[];
            foreach ($names as $name => $arrSName) {
             $namesSum[$name]=['dancer_count'=>count($arrSName),'in_count'=> array_sum($arrSName)];   
            }
       $data=[];
         foreach ($namesSum as $name => $arrName) {
         $data[]=['club'=>$name,'dancer_count'=>$arrName['dancer_count'],'in_count'=>$arrName['in_count']];    
             
         }
        
      return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => 
        	[
            	'pageSize' =>  false,
        	],

    ]);  
        
    }
}
