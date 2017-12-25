<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dancer_trener".
 *
 * @property integer $dancer_id
 * @property integer $trener_id
 *
 * @property Dancer $dancer
 * @property Trener $trener
 */
class DancerTrener extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dancer_trener';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dancer_id', 'trener_id'], 'required'],
            [['dancer_id', 'trener_id'], 'integer'],
            [['dancer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dancer::className(), 'targetAttribute' => ['dancer_id' => 'id']],
            [['trener_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trener::className(), 'targetAttribute' => ['trener_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dancer_id' => 'Dancer ID',
            'trener_id' => 'Trener ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancer()
    {
        return $this->hasOne(Dancer::className(), ['id' => 'dancer_id'])->inverseOf('dancerTreners');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrener()
    {
        return $this->hasOne(Trener::className(), ['id' => 'trener_id'])->inverseOf('dancerTreners');
    }

    
    /**
     * @inheritdoc
     * @return DancerTrenerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DancerTrenerQuery(get_called_class());
    }
}
