<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dance".
 *
 * @property integer $id
 * @property string $name
 *
 * @property InDance[] $inDances
 * @property Krest[] $krests
 */
class Dance extends \yii\db\ActiveRecord
{
    public $progList =  [
                            '1' => 'St',
                            '2' => 'La'
                        ];
    
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['fullName'], 'safe'],
            [['prog'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Сокр. наимен.',
            'prog' => 'Программа',
            'fullName' => 'Полн. наимен.',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInDances()
    {
        return $this->hasMany(InDance::className(), ['dance_id' => 'id'])->inverseOf('dance');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKrests()
    {
        return $this->hasMany(Krest::className(), ['dance_id' => 'id'])->inverseOf('dance');
    }

    /**
     * @inheritdoc
     * @return DanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DanceQuery(get_called_class());
    }
    
    
}
