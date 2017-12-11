<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "club".
 *
 * @property integer $id
 * @property string $name
 * @property integer $city_id
 *
 * @property City $city
 * @property Dancer[] $dancers
 */
class Club extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'club';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'city_id' => 'City ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id'])->inverseOf('clubs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancers()
    {
        return $this->hasMany(Dancer::className(), ['club' => 'id'])->inverseOf('club0');
    }

    /**
     * @inheritdoc
     * @return ClubQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClubQuery(get_called_class());
    }
}
