<?php

namespace app\models;

use Yii;
use app\controllers;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $solo
 * @property integer $otd
 * @property integer $program
 * @property integer $agemin
 * @property integer $agemax
 * @property string $clas
 * @property integer $skay
 * @property string $dances
 *
 * @property Age $age
 * @property Chess[] $chesses
 * @property Tur[] $turs
 */
class Category extends \yii\db\ActiveRecord
{
    public $programmList = [
        '1' => 'St',
        '2' => 'La',
        '3' => '10 D',
        '4' => '10 D разд.',
    ];
    
    public $soloList = [
        '0'=>'Соло', 
        '1'=>'Пары',
    ];
    
    public $skayList = [
        '1' => 'Баллы',
        '2' => 'Кресты',
        '3' => 'Скей тинг',
    ];
    
    public $typeCompList = [
        '0' => 'Рейтинг',
        '1' => 'Класс',
    ];
    
    public $classList = [
        'N' => 'N',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
        'D' => 'D',
        'E' => 'E',
    ];
    
    public $dancingOrderList = [
        '0' => 'Танцы',
        '1' => 'Заходы',
    ];
    
    public $chesses_list;
    
    
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['solo', 'otd_id', 'program', 'agemin', 'agemax', 'skay', 'type_comp', 'dancing_order'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['clas', 'dances', 'chesses_list'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Категория',
            'solo' => 'Соло',
            'otd_id' => 'Otd',
            'program' => 'Программа',
            'agemin' => 'min возраст',
            'agemax' => 'max возраст',
            'clas' => 'Класс',
            'skay' => 'Подсчет результатов',
            'dances' => 'Перечень танцев',
            'reg_pairs' => 'Пар',
            'judges_count' => 'Cудий',
            'chesses_list' => 'Судейская комиссия',
            'dancing_order' => 'Посл. танцев',
            'type_comp' => 'Тип соревн.',
        ];
    }




    public function beforeSave($insert)
    {
        if ($this->clas>''){
            $this->clas = implode(", ", $this->clas);
        }
        if ($this->dances){
            $this->dances = implode(", ", $this->dances);
        }
        
        if ($this->chesses_list){
            $judgeArr = $this->chesses_list;
            Chess::deleteAll(['category_id' => $this->id]);
            $i=1;
            foreach ($judgeArr as $judge) {   
                $chess = new Chess;
                $chess->judge_id = $judge;
                $chess->category_id = $this->id;
                $i==1 ? $chess->chief = 1 : $chess->chief = 0;
                $chess->nomer = $i++;
                $chess->save();
            }
        }
        // print_r($chess);
        // exit;
        return  true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   
    public function getOtd()
    {
        return $this->hasOne(Otd::className(), ['id' => 'otd_id'])->inverseOf('category');
    }
    
    public function getOtdList() 
    {
        return Otd::find()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChesses()
    {
        return $this->hasMany(Chess::className(), ['category_id' => 'id'])->inverseOf('category');
    }

    public function getJudges()
    {
        return $this->hasMany(Judge::className(), ['id' => 'judge_id'])->viaTable('chesses', ['category_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurs()
    {
        return $this->hasMany(Tur::className(), ['category_id' => 'id'])->inverseOf('category');
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
//    public static function find()
//    {
//        return new CategoryQuery(get_called_class());
//    }

    public function getCatRegPairs($id)
    { 
        if ($c = Tur::find()
                ->where(['category_id' => $id])
                ->orderBy(['nomer'=> SORT_ASC])
                ->one()){
            return $c->getIns()->count();
        } else {
            return 0;
        }
    }

    public function getDanceList()
    {
        return ArrayHelper::map(Dance::find()->all(), 'id', 'name');
    }

    public function getDanceToString($dances)
    {
        return implode(", ", Dance::find()->asArray()->select('name')->where(['id' => explode(", ", $dances)])->column());
    }
    
//    public static function getClassList()
//    {
//        return ArrayHelper::map(Clas::find()->all(), 'id', 'name');
//    }
}