<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dancer".
 *
 * @property integer $id
 * @property string $name
 * @property string $sname
 * @property string $date
 * @property integer $clas_id_st
 * @property integer $clas_id_la
 * @property string $booknumber
 * @property integer $gender
 * @property integer $club
 *
 * @property Couple[] $couples
 * @property Couple[] $couples0
 * @property Clas $clasIdSt
 * @property Clas $clasIdLa
 * @property Club $club0
 * @property DancerTrener[] $dancerTreners
 */
class Dancer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dancer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['clas_id_st', 'clas_id_la', 'gender', 'club'], 'integer'],
            [['club'], 'required'],
            [['name', 'sname', 'booknumber'], 'string', 'max' => 250],
            [['clas_id_st'], 'exist', 'skipOnError' => true, 'targetClass' => Clas::className(), 'targetAttribute' => ['clas_id_st' => 'id']],
            [['clas_id_la'], 'exist', 'skipOnError' => true, 'targetClass' => Clas::className(), 'targetAttribute' => ['clas_id_la' => 'id']],
            [['club'], 'exist', 'skipOnError' => true, 'targetClass' => Club::className(), 'targetAttribute' => ['club' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sname' => 'Sname',
            'date' => 'Date',
            'clas_id_st' => 'Clas Id St',
            'clas_id_la' => 'Clas Id La',
            'booknumber' => 'Booknumber',
            'gender' => 'Gender',
            'club' => 'Club',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouples()
    {
        return $this->hasMany(Couple::className(), ['dancer_id_1' => 'id'])->inverseOf('dancerId1');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouples0()
    {
        return $this->hasMany(Couple::className(), ['dancer_id_2' => 'id'])->inverseOf('dancerId2');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasIdSt()
    {
        return $this->hasOne(Clas::className(), ['id' => 'clas_id_st'])->inverseOf('dancers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasIdLa()
    {
        return $this->hasOne(Clas::className(), ['id' => 'clas_id_la'])->inverseOf('dancers0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClub0()
    {
        return $this->hasOne(Club::className(), ['id' => 'club'])->inverseOf('dancers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancerTreners()
    {
        return $this->hasMany(DancerTrener::className(), ['dancer_id' => 'id'])->inverseOf('dancer');
    }

    /**
     * @inheritdoc
     * @return DancerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DancerQuery(get_called_class());
    }
}
