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
//            [['time'], 'required'],
            [['time', 'tur_name'], 'safe'],
            [['otd_id', 'tur_id'], 'integer'],
//            [['name'], 'string', 'max' => 250],
            [['tur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tur::className(), 'targetAttribute' => ['tur_id' => 'id']],
            [['category_name', 'tur_number', 'reg_pairs', 'programm', 'dances', 'heats_count', 'dances_count'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Время',
            'otd_id' => 'Отделение',
            'tur_id' => 'Тур',
            'category_name' => 'Категория',
            'tur_number' => 'Номер тура',
            'reg_pairs' => 'Зарег. пар',
            'programm' => 'Программа',
            'dances' => 'Танцы',
            'heats_count' => 'Заходов',
            'dances_count' => 'Танцев',
            'tur_name' => 'Тур',
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
