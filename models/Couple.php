<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "couple".
 *
 * @property integer $id
 * @property integer $dancer_id_1
 * @property integer $dancer_id_2
 * @property integer $nomer
 *
 * @property Dancer $dancerId1
 * @property Dancer $dancerId2
 * @property In[] $ins
 */
class Couple extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'couple';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dancer_id_1', 'dancer_id_2'], 'integer'],
            [['dancer_id_1'], 'exist', 'skipOnError' => true, 'targetClass' => Dancer::className(), 'targetAttribute' => ['dancer_id_1' => 'id']],
            [['dancer_id_2'], 'exist', 'skipOnError' => true, 'targetClass' => Dancer::className(), 'targetAttribute' => ['dancer_id_2' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dancer_id_1' => 'Dancer Id 1',
            'dancer_id_2' => 'Dancer Id 2',
            'club' => 'Клуб',
            'trenersString' => 'Тренер',
            'age' => 'Возраст',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancerId1()
    {
        return $this->hasOne(Dancer::className(), ['id' => 'dancer_id_1'])->inverseOf('couples');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancerId2()
    {
        return $this->hasOne(Dancer::className(), ['id' => 'dancer_id_2'])->inverseOf('couples0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIns()
    {
        return $this->hasMany(In::className(), ['couple_id' => 'id'])->inverseOf('couple');
    }

    public function getAge()
    {
        $a1 = $this->dancerId1 ? $this->dancerId1->date : NULL;
        $a2 = $this->dancerId2 ? $this->dancerId2->date : NULL;
        $d = (int)date('Y') - (int)($a1 < $a2 ? $a1 : $a2);
        return 'dd';//$d==(int)date('Y') ? '-': $d;
    }

    public function getTrenersString()
    {
        if ($this->dancerId1 && $this->dancerId2) {
            return implode(', ', array_merge($this->dancerId1->trenersList, array_diff($this->dancerId2->trenersList,$this->dancerId1->trenersList)));
        } elseif (!$this->dancerId1) {
            return implode(', ', $this->dancerId2->trenersList);
        } else {
            return implode(', ', $this->dancerId1->trenersList);
        }
    }

    public function getClub()
    {
        $c1 = $this->dancerId1 ? $this->dancerId1->club0 : NULL;
        $c2 = $this->dancerId2 ? $this->dancerId2->club0 : NULL;

        if (!$c1 && !$c2)
        {
            return 'Не указан';
        } elseif (!$c1) {
            return $c2->name;
        } elseif (!$c2) {
            return $c1->name; 
        } elseif ($c1->id == $c2->id) {
            return $c1->name;
        } else {
            return $c1->name . ', ' . $c2->name;
        }    
    }



    /**
     * @inheritdoc
     * @return CoupleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoupleQuery(get_called_class());
    }
}
