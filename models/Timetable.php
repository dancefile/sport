<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timetable".
 *
 * @property integer $id
 * @property string $time
 * @property integer $otd
 * @property integer $tur_id
 * @property string $name
 *
 * @property Tur $tur
 */
class Timetable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timetable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'required'],
            [['time'], 'safe'],
            [['otd', 'tur_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['tur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tur::className(), 'targetAttribute' => ['tur_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'otd' => 'Otd',
            'tur_id' => 'Tur ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTur()
    {
        return $this->hasOne(Tur::className(), ['id' => 'tur_id'])->inverseOf('timetables');
    }

    /**
     * @inheritdoc
     * @return TimetableQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TimetableQuery(get_called_class());
    }
}
