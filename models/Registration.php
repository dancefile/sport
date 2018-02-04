<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\helpers\ArrayHelper;




/**
 * Description of Registration
 *
 * @author Михаилус
 */
class Registration extends \yii\base\Model
{
    public $print_check=true;
    public $d1_id;
    public $d1_sname;
    public $d1_name;
    public $d1_date;
    public $d1_class_st;
    public $d1_class_la;
    public $d1_booknumber;
    public $d2_id;
    public $d2_sname;
    public $d2_name;
    public $d2_date;
    public $d2_class_st;
    public $d2_class_la;
    public $d2_booknumber;
    public $club;
    public $city;
    public $country;
    public $d_trener1_name;
    public $d_trener1_sname;
    public $d_trener2_name;
    public $d_trener2_sname;
    public $d_trener3_name;
    public $d_trener3_sname;
    public $d_trener4_name;
    public $d_trener4_sname;
    public $d_trener5_name;
    public $d_trener5_sname;
    public $d_trener6_name;
    public $d_trener6_sname;
    public $coupleId;
    public $turPair;
    public $turSolo_M;
    public $turSolo_W;
    public $inPair;
    public $inSolo;
    
    
   
    
    public function rules()
    {
        return [
            [['d1_name', 'd2_name'], 'safe'],
            [['d1_class_st', 'd1_class_la', 'd2_class_st', 'd2_class_la', 'print_check'], 'safe'],
            [['d1_booknumber', 'd2_booknumber'], 'safe'],
            [['club', 'city', 'country'], 'safe'],
            [['d1_sname', 'd2_sname'], 'safe'],
            [['d_trener1_name', 'd_trener2_name', 'd_trener3_name', 'd_trener4_name', 'd_trener5_name', 'd_trener6_name'], 'safe'],
            [['d_trener1_sname', 'd_trener2_sname', 'd_trener3_sname', 'd_trener4_sname', 'd_trener5_sname', 'd_trener6_sname'], 'safe'],
            
            
//            ['d1_sname', 'required', 'when' => function ($model) {
//                    return $model->d2_sname == '';
//                }, 
//                'whenClient' => 'function (attribute, value) {
//                    return $("#d2_sname").val() == "";
//                }', 
//                'message' => 'Заполните field 1 либо field 2'
//            ],
//
//            ['d2_sname', 'required', 'when' => function ($model) {
//                return $model->d1_sname == '';
//                }, 
//                'whenClient' => 'function (attribute, value) {
//                    return $("#d1_sname").val() == "";
//                }', 
//                'message' => 'Заполните field 1 либо field 2'
//            ],
            
            ['turPair', 'checkTurPair'],
            ['turSolo_M', 'checkSolo_M'],
            ['turSolo_W', 'checkSolo_W'],
                        
        ];
    }
    
    public function checkTurPair($attr)
    {
        if (array_filter($this->turPair)) {
            if (!$this->d1_sname || !$this->d2_sname) {
                \Yii::$app->session->setFlash('error', "Укажите данные обоих танцоров!");
                $this->addError($attr, 'Error');
            }
        } elseif (($this->d1_sname && $this->d2_sname) && (!array_filter($this->turSolo_M) || !array_filter($this->turSolo_W))) {
            \Yii::$app->session->setFlash('error', "Не указана категория для второго танцора!");
            $this->addError($attr, 'Error');
        } else {
            if (!array_filter($this->turSolo_M) && !array_filter($this->turSolo_W)) {
                \Yii::$app->session->setFlash('error', "Не указана категория!");
                $this->addError($attr, 'Error');
            }
        }
    }
    
    public function checkSolo_M($attr)
    {
        if (array_filter($this->turSolo_M) && !$this->d1_sname) { 
            \Yii::$app->session->setFlash('error', "Укажите данные танцора М!");
            $this->addError($attr, 'Error');
        }
    }
    
    public function checkSolo_W($attr)
    {
        if (array_filter($this->turSolo_W) && !$this->d2_sname) {
            \Yii::$app->session->setFlash('error', "Укажите данные танцора Ж!");
            $this->addError($attr, 'Error');
        }
    }
    
     
    public static function getClassList()
    {
        return ArrayHelper::map(Clas::find()->all(), 'id', 'name');
    }
    
    public static function getClubList()
    {
        return ArrayHelper::map(Club::find()->all(), 'id', 'name');
    }
    
    public function getCityList()
    {
        return City::find()->select('name')->column();
    }

    public function getCountryList()
    {
        return Country::find()->select('name')->column();
    }
    
    public function getTrenerSnameList()
    {
        return ArrayHelper::map(Trener::find()->asArray()->all(), 'id', 'sname');   
    }
    
    public function getTrenerNameList()
    {
        return ArrayHelper::map(Trener::find()->asArray()->all(), 'id', 'name');   
    }

    public function turInPair($couple)
    {
        return In::find()
            ->where(['couple_id' => $couple])
            ->asArray()->all();
    }
    
    public function turListPair()
    {
        return Tur::find()
            ->joinWith(['category', 'category.otd', 'ins'])
            ->select(['tur.id', 'category.name', 'tur.category_id', 'otd.name otd', 'in.couple_id couple'])
            ->where(['category.solo' => 1])
            ->groupBy('tur.category_id')
            ->andWhere(min(['tur.nomer']))
            ->orderBy(['category.otd_id' => SORT_ASC, 'tur.category_id' => SORT_ASC])
            ->asArray()->all();
    }
    
    public function turInSolo($couple)
    {
        return In::find()
            ->where(['couple_id' => $couple])
            ->asArray()->all();
    }
    
    public function turListSolo()
    {
        return Tur::find()
            ->joinWith(['category', 'category.otd', 'ins'])
            ->select(['tur.id', 'category.name', 'tur.category_id', 'otd.name otd'])
            ->where(['category.solo' => 0])
            ->groupBy('tur.category_id')
            ->andWhere(min(['tur.nomer']))
            ->orderBy(['category.otd_id' => SORT_ASC, 'tur.category_id' => SORT_ASC])
            ->asArray()->all();
    }
    
    /**
     * 
     * @param \app\models\app\models\In $model
     */
    public function loadFromRecord($model)
    {
        $couple = $model->couple;
        $this->coupleId = $couple->id;
        $dancer1 = $couple->dancerId1;
        $dancer2 = $couple->dancerId2;
        if ($dancer1){
            if ($dancer1->club0){
                $this->city = $dancer1->club0->city? $dancer1->club0->city->name:'';
                $this->country = $dancer1->club0->city->country? $dancer1->club0->city->country->name:'';
            }
        }
        $this->loadDancerAttr($dancer1 , $dancer2);
        $this->loadTrenersAttr($dancer1, $dancer2);
        
        foreach ($this->turListPair() as $key => $tur) {
            $this->inPair[$key] = $tur;
            
            foreach ($this->turInPair($model->couple_id) as $coupleIn) {
                if ($this->inPair[$key]['id'] == $coupleIn['tur_id']){
                    $this->inPair[$key]['nomer'] = $coupleIn['nomer'];
                    break;
                } else {
                    $this->inPair[$key]['nomer'] = NULL;
                }
            }         
        }
        
        $arr=$this->turInSolo($model->couple_id);
        foreach ($this->turListSolo() as $key => $tur) {
            $this->inSolo[$key] = $tur;

            foreach ($arr as $coupleIn) { 
                if ($this->inSolo[$key]['id'] == $coupleIn['tur_id']){     
                    if ($coupleIn['who'] == 1) {
                        $this->inSolo[$key]['nomer_M'] = $coupleIn['nomer'];
                    }
                    if ($coupleIn['who'] == 2){
                        $this->inSolo[$key]['nomer_W'] = $coupleIn['nomer'];
                    }
                } else {
                 if (!isset($this->inSolo[$key]['nomer_M']))   $this->inSolo[$key]['nomer_M'] = NULL;
                 if (!isset($this->inSolo[$key]['nomer_W']))   $this->inSolo[$key]['nomer_W'] = NULL;
                }
            } 
        }
    }
    
    private function loadDancerAttr($dancer1, $dancer2)
    {   
        if (isset($dancer1->id)){
            $this->d1_id = $dancer1->id;
            $this->d1_sname = $dancer1->sname;
            $this->d1_name = $dancer1->name;
            $this->d1_date = $dancer1->date;
            $this->d1_class_st = $dancer1->clas_id_st;
            $this->d1_class_la = $dancer1->clas_id_la;
            $this->d1_booknumber = $dancer1->booknumber;
            $this->club = $dancer1->club0? $dancer1->club0->name:null;
        }
        if (isset($dancer2->id)){
            $this->d2_id = $dancer2->id;
            $this->d2_sname = $dancer2->sname;
            $this->d2_name = $dancer2->name;
            $this->d2_date = $dancer2->date;
            $this->d2_class_st = $dancer2->clas_id_st;
            $this->d2_class_la = $dancer2->clas_id_la;
            $this->d2_booknumber = $dancer2->booknumber;
            $this->club = $dancer2->club0? $dancer2->club0->name:null;
        }
        
    }
    
    private function loadTrenersAttr($dancer1, $dancer2)
    {
        if (isset($dancer1->id)){
            $dancer1_id = $dancer1->id;
            $treners = DancerTrener::find()->where(['dancer_id'=>$dancer1_id])->all();
            $i=1;
            foreach ($treners as $trener) {
                $this->{'d_trener'. $i .'_name'} = $trener->trener->name;
                $this->{'d_trener'. $i .'_sname'} = $trener->trener->sname;
                $i++;
            }
        }
        if (isset($dancer2->id)){
            $dancer2_id = $dancer2->id;
            $treners = DancerTrener::find()->where(['dancer_id'=>$dancer2_id])->all();
            $i=1;
            foreach ($treners as $key=>$trener) {
                $this->{'d_trener'. $i .'_name'} = $trener->trener->name;
                $this->{'d_trener'. $i .'_sname'} = $trener->trener->sname;
                $i++;
            }
        }
        
    }
}
