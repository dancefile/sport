<?php

namespace app\models;

use Yii;

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
            [['dancer_id_1', 'dancer_id_2', 'nomer'], 'integer'],
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
            'nomer' => 'Nomer',
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

    /**
     * @inheritdoc
     * @return CoupleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoupleQuery(get_called_class());
    }
}
