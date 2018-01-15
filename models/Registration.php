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
    public $d1_sname;
    public $d1_name;
    public $d1_date;
    public $d1_class_st;
    public $d1_class_la;
    public $d1_booknumber;
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
    public $turPair;
    public $turSolo_M;
    public $turSolo_W;
 
    
    public function rules()
    {
        return [
            [['d1_name', 'd1_name'], 'safe'],
            [['d1_class_st', 'd1_class_la', 'd2_class_st', 'd2_class_la'], 'safe'],
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

    public function turListPair()
    {
        return Tur::find()
            ->joinWith(['category', 'category.otd', 'ins'])
            ->select(['tur.id', 'category.name', 'tur.category_id', 'otd.name otd'])
            ->where(['category.solo' => 1])
            ->groupBy('tur.category_id')
            ->andWhere(min(['tur.nomer']))
            ->orderBy(['category.otd_id' => SORT_ASC, 'tur.category_id' => SORT_ASC])
            ->asArray()->all();
    }

    public function turListSolo()
    {
        return Tur::find()
            ->joinWith(['category', 'category.otd', 'ins'])
            ->select(['tur.id', 'category.name', 'tur.category_id', 'otd.name otd'])
            ->where(['category.solo' => 2])
            ->groupBy('tur.category_id')
            ->andWhere(min(['tur.nomer']))
            ->orderBy(['category.otd_id' => SORT_ASC, 'tur.category_id' => SORT_ASC])
            ->asArray()->all();
    }
}
