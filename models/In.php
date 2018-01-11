<?php

namespace app\models;

use Yii;
use app\models\Clas;
use app\models\Tur;
use app\models\Dancer;
use app\models\Club;
use app\models\City;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "in".
 *
 * @property integer $id
 * @property integer $couple_id
 * @property integer $tur_id
 *
 * @property Couple $couple
 * @property Tur $tur
 * @property InDance $inDance
 */
class In extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in';
    }


    public $dancer1=['name'=>'', 'sname'=>'', 'date'=>'', 'clas_id_st'=>'', 'clas_id_la'=>'', 'booknumber'=>''];
    public $dancer2=['name'=>'', 'sname'=>'', 'date'=>'', 'clas_id_st'=>'', 'clas_id_la'=>'', 'booknumber'=>''];
    public $common=['club'=>'', 'city'=>'', 'country'=>''];
    public $turPair;
    public $turSolo_M;
    public $turSolo_W;
    public $dancer_trener=['name', 'sname'];



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['couple_id', 'tur_id'], 'required'],
            [['couple_id', 'tur_id'], 'integer'],
            [['couple_id'], 'exist', 'skipOnError' => true, 'targetClass' => Couple::className(), 'targetAttribute' => ['couple_id' => 'id']],
            [['tur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tur::className(), 'targetAttribute' => ['tur_id' => 'id']],
            [['dancer1', 'dancer2', 'common', 'turPair', 'turSolo_M', 'turSolo_W', 'dancer_trener'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'couple_id' => 'Couple ID',
            'tur_id' => 'Tur ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouple()
    {
        return $this->hasOne(Couple::className(), ['id' => 'couple_id'])->inverseOf('ins');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTur()
    {
        return $this->hasOne(Tur::className(), ['id' => 'tur_id'])->inverseOf('ins');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInDance()
    {
        return $this->hasOne(InDance::className(), ['id' => 'id'])->inverseOf('id0');
    }

    public function getClassList()
    {
        return ArrayHelper::map(Clas::find()->all(), 'id', 'name');
    }

    public function getDancerList()
    {
        return Dancer::find()->select('sname')->all();
    }

    public function getClubList()
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

    public function getCity()
    {
        $city1 = isset($this->couple->dancerId1->club0->city) ? $this->couple->dancerId1->club0->city : false;
        $city2 = isset($this->couple->dancerId2->club0->city) ? $this->couple->dancerId2->club0->city : false;
        if (!$city1 && !$city2) {
            return '-';
        } elseif (!$city2) {
            return $city1->name;
        } elseif (!$city1) {
            return $city2->name;
        } elseif ($city1->id == $city2->id) {
            return $city1->name;
        } else {
            return $city1->name . ', ' . $city2->name;
        } 
    }

    public function getFullName()
    {
        return $this->name.' '.$this->sname;
    }


    public function getTrenerList()
    {
        return ArrayHelper::map(Trener::find()->asArray()->all(), 'sname', 'fullName');
        
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

    /**
     * @inheritdoc
     * @return InQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InQuery(get_called_class());
    }
}
