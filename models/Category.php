<?php

namespace app\models;

use Yii;
use app\controllers;

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
            // [[], 'string', 'max' => 100],
            [['clas', 'dances'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название категории',
            'solo' => 'Соло',
            'otd_id' => 'Otd',
            'program' => 'Программа',
            'agemin' => 'min возраст',
            'agemax' => 'max возраст',
            'clas' => 'Класс',
            'skay' => 'Подсчет результатов',
            'dances' => 'Перечень танцев',
            'reg_pairs' => 'Пар',
            'judges_count' => 'Cудий'
        ];
    }


    public function beforeSave($insert)
    {
        $this->clas = implode($this->clas);
        $this->dances = implode($this->dances);
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
}


