<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "krest".
 *
 * @property integer $id
 * @property integer $judge_id
 * @property integer $tur_id
 * @property integer $dance_id
 * @property integer $ball
 *
 * @property Judge $judge
 * @property Tur $tur
 * @property Dance $dance
 */
class Krest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'krest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['judge_id', 'tur_id', 'dance_id', 'ball'], 'required'],
            [['judge_id', 'tur_id', 'dance_id', 'ball'], 'integer'],
            [['judge_id'], 'exist', 'skipOnError' => true, 'targetClass' => Judge::className(), 'targetAttribute' => ['judge_id' => 'id']],
            [['tur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tur::className(), 'targetAttribute' => ['tur_id' => 'id']],
            [['dance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dance::className(), 'targetAttribute' => ['dance_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judge_id' => 'Judge ID',
            'tur_id' => 'Tur ID',
            'dance_id' => 'Dance ID',
            'ball' => 'Ball',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJudge()
    {
        return $this->hasOne(Judge::className(), ['id' => 'judge_id'])->inverseOf('krests');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTur()
    {
        return $this->hasOne(Tur::className(), ['id' => 'tur_id'])->inverseOf('krests');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDance()
    {
        return $this->hasOne(Dance::className(), ['id' => 'dance_id'])->inverseOf('krests');
    }

    /**
     * @inheritdoc
     * @return KrestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KrestQuery(get_called_class());
    }
}
