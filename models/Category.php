<?php

namespace app\models;

use Yii;

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
 * @property integer $age_id
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
            [['solo', 'otd_id', 'program', 'agemin', 'agemax', 'age_id', 'skay'], 'integer'],
            [['name', 'clas'], 'string', 'max' => 200],
            [['dances'], 'string', 'max' => 100],
            [['age_id'], 'exist', 'skipOnError' => true, 'targetClass' => Age::className(), 'targetAttribute' => ['age_id' => 'id']],
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
            'solo' => 'Solo',
            'otd_id' => 'Otd',
            'program' => 'Program',
            'agemin' => 'Agemin',
            'agemax' => 'Agemax',
            'age_id' => 'Age ID',
            'clas' => 'Clas',
            'skay' => 'Skay',
            'dances' => 'Dances',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAge()
    {
        return $this->hasOne(Age::className(), ['id' => 'age_id'])->inverseOf('category');
    }

    public function getOtds()
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

}


