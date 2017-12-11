<?php

namespace app\models;

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
            [['category_id', 'nomer', 'zahodcount', 'typezahod', 'ParNextTur', 'typeSkating', 'status'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['dances'], 'string', 'max' => 200],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'nomer' => 'Nomer',
            'name' => 'Name',
            'zahodcount' => 'Zahodcount',
            'typezahod' => 'Typezahod',
            'dances' => 'Dances',
            'ParNextTur' => 'Par Next Tur',
            'typeSkating' => 'Type Skating',
            'status' => 'Status',
        ];
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
}
