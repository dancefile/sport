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
            [['time', 'tur_name', 'tur_time'], 'safe'],
            [['otd_id', 'tur_id'], 'safe'],
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
    
    public function loadTurData($otd_id)
    {
        $turs = \app\models\Tur::find()->joinWith(['category', 'category.otd', 'ins'])->where(['category.otd_id'=>$otd_id])->asArray()->all();
        
        $danceTime = Setings::find()->one();
        $dt = $danceTime->danceTime;
        
        foreach ($turs as $tur) {
            if ($tur['category']['program']==4){
                self::timeTableSave($tur, '10 D La', $dt);
                self::timeTableSave($tur, '10 D St', $dt);
            } else {
                switch ($tur['category']['program']) {
                    case 1:
                        $programm = "La";
                        break;
                    case 2:
                        $programm = "St";
                        break;
                    case 3:
                        $programm = "10 D";
                        break;
                }
                self::timeTableSave($tur, $programm, $dt);
            }
        } 
        self::timeUpdate($otd_id);
    }
    
    public function getDancesString($dances) {
        $dance_list = \yii\helpers\ArrayHelper::map(Dance::find()->all(), 'id', 'name');
        $s = array_intersect_key($dance_list, explode(', ', $dances));
        
        return implode(', ', $s['name']);
        
    }


    private function timeTableSave($tur, $programm, $dt)
    {
        $tt = new Timetable();  
        $tt->otd_id = $tur['category']['otd_id'];
        $tt->tur_id = $tur['id'];
        $tt->tur_name = $tur['name'];
        $tt->category_name = $tur['category']['name'];
        $tt->tur_number = $tur['nomer'];
        $tt->reg_pairs = count($tur['ins']);
        $tt->programm = $programm;
        $tt->dances = $tur['dances'];
        $tt->heats_count = $tur['zahodcount'];
        $tt->dances_count = count(explode(',', $tur['dances']));
        $tt->tur_time = date('H:i:s', StrToTime($dt) * $tur['zahodcount'] * count(explode(',', $tur['dances'])));
        $tt->save();
    }




    public function timeUpdate($otd_id)
    {
        $otd = Otd::find()->where(['id'=>$otd_id])->one();
        $startTime = $otd->startTime;
        
        $timeTable = Timetable::find()->where(['otd_id'=>$otd_id])->orderBy(['sortItem' => SORT_ASC])->all();
        
        foreach ($timeTable as $record) {
            $record->time = $startTime;
            $record->save();
            $startTime = date('H:i:s', StrToTime($record->time) + StrToTime($record->tur_time));
        }
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
