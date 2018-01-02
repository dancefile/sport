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
            [['solo', 'otd_id', 'program', 'agemin', 'agemax', 'skay'], 'integer'],
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
            'chesses_list' => 'Судейская комиссия'
        ];
    }

    public $chesses_list;


    public function beforeSave($insert)
    {
        $this->clas = implode(", ", $this->clas);
        $this->dances = implode(", ", $this->dances);

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
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public function getCatRegPairs($id)
    { 
        $s=0;
        $turs = Tur::find()->where('category_id = :id', [ 'id' => $id ])->all();
        foreach ($turs as $tur) {
            $s = $s+$tur->regPairs;
        }
        return $s;        
    }

    public static function getSoloList(){
        return ['0'=>'Соло', '1'=>'Пары'];
    }

    public function getDanceList()
    {
        return ArrayHelper::map(Dance::find()->all(), 'id', 'name');
    }

    public function getDanceToString($dances)
    {
        return implode(", ", Dance::find()->asArray()->select('name')->where(['id' => explode(", ", $dances)])->column());
    }

    public static function getProgrammList(){
        return ['1' => 'Latina',
                '2' => 'Standart',
                '3' => '10 dances',
                ];
    }

}


