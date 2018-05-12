<?php


namespace app\models;

use yii\data\ActiveDataProvider;

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
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }
}
