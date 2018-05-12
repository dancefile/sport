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
        $query = new \yii\db\Query();        
        $query 
                ->select([
                    'club.name club', 
                    'club.id id', 
                    'COUNT(DISTINCT(dancer.id)) dancer_count',
                    'COUNT(DISTINCT(in.id)) in_count'
                    ])
                ->from('club')
                ->join('LEFT JOIN', 'dancer', 'dancer.club=club.id')
                ->join('LEFT JOIN', 'couple', 'couple.dancer_id_1=dancer.id OR couple.dancer_id_2=dancer.id')
                ->join('LEFT JOIN', 'in', 'in.couple_id=couple.id')
                ->groupBy('club')
                ->orderBy('club')
                ;
        $data=[];
        $names=[];
        foreach ($query->each() as $row) {
        if ($row['dancer_count']){
            if (isset($names[$row['club']])) {
                $names[$row['club']]['dancer_count'] = $names[$row['club']]['dancer_count']+$row['dancer_count'];
                $names[$row['club']]['in_count'] = $names[$row['club']]['in_count']+$row['in_count'];
            }
            else {
              $names[$row['club']]=['id'=>$row['id'],'dancer_count'=>$row['dancer_count'],'in_count'=>$row['in_count']];  
            }
        
        }
            
        }
         foreach ($names as $name => $arrName) {
         $data[]=['club'=>$name,'id'=>$arrName['id'],'dancer_count'=>$arrName['dancer_count'],'in_count'=>$arrName['in_count']];    
             
         }
        
       // $dataProvider = new ActiveDataProvider([
        //    'query' => $query,
        //]);
        //exit;
       // return $dataProvider;
        
      return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => 
        	[
            	'pageSize' =>  false,
        	],

    ]);  
        
    }
}
