<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "in_dance".
 *
 * @property integer $id
 * @property integer $dance_id
 * @property integer $zahod
 *
 * @property In $id0
 * @property Dance $dance
 */
class InDance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in_dance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'dance_id', 'zahod'], 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => In::className(), 'targetAttribute' => ['id' => 'id']],
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
            'dance_id' => 'Dance ID',
            'zahod' => 'Zahod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(In::className(), ['id' => 'id'])->inverseOf('inDance');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDance()
    {
        return $this->hasOne(Dance::className(), ['id' => 'dance_id'])->inverseOf('inDances');
    }

    /**
     * @inheritdoc
     * @return InDanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InDanceQuery(get_called_class());
    }
}
