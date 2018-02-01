<?php

namespace app\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "tur".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $nomer
 * @property string $name
 * @property integer $zahodcount
 * @property integer $typezahod
 * @property string $dances
 * @property integer $ParNextTur
 * @property integer $typeSkating
 * @property integer $status
 *
 * @property In[] $ins
 * @property Krest[] $krests
 * @property Timetable[] $timetables
 * @property Category $category
 */




class Tur extends \yii\db\ActiveRecord
{
    public $typezahodList = [
                                '1' => 'Постоянный',
                                '2' => 'Переменный',
                                '3' => 'Чередование',
                            ];
            
            
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'nomer'], 'required'],
            [['nomer', 'zahodcount', 'typezahod', 'ParNextTur', 'typeSkating', 'status'], 'integer'],
            [['name'], 'string', 'max' => 250],
            // [['dances'], 'string', 'max' => 200],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['dances', 'turTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'nomer' => '№',
            'name' => 'Название тура',
            'zahodcount' => 'Кол-во заходов',
            'typezahod' => 'Форм. заходов',
            'dances' => 'Перечень танцев',
            'ParNextTur' => 'Пар в след. тур',
            'typeSkating' => 'Система подсчета',
            'status' => 'Статус',
            'turTime' => 'Время',
        ];
    }

    public function beforeSave($insert)
    {
        if (isset($this->chesses_list)){
            $this->dances = implode(", ", $this->dances);
        }
        return  true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIns()
    {
        return $this->hasMany(In::className(), ['tur_id' => 'id'])->inverseOf('tur');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKrests()
    {
        return $this->hasMany(Krest::className(), ['tur_id' => 'id'])->inverseOf('tur');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimetables()
    {
        return $this->hasMany(Timetable::className(), ['tur_id' => 'id'])->inverseOf('tur');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->inverseOf('turs');
    }

    /**
     * @inheritdoc
     * @return TurQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TurQuery(get_called_class());
    }
    

    public function getRegPairs()
    {
        $count = $this->getIns()->count();
        return $count;
    }

    public function getDanceList($category_id)
    {
        $arr = Category::find()->select('dances')->where(['id'=>$category_id])->asArray()->one();
        $category_dances = explode (', ', $arr['dances']);

        return ArrayHelper::map(Dance::find()->where(['in','id',$category_dances])->all(), 'id', 'name');
    }

    public function getDanceToString($dances)
    {
        return implode(", ", Dance::find()->asArray()->select('name')->where(['id' => explode(", ", $dances)])->column());
    }

    public static function getRegPairsList()
    {
        $pairs = Tur::find()->ins->count()->all();
        return $pairs;
    }
}

