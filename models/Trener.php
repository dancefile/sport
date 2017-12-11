<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trener".
 *
 * @property integer $id
 * @property string $name
 * @property string $sname
 *
 * @property DancerTrener[] $dancerTreners
 */
class Trener extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trener';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sname'], 'string', 'max' => 250],
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
            'sname' => 'Sname',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancerTreners()
    {
        return $this->hasMany(DancerTrener::className(), ['trener_id' => 'id'])->inverseOf('trener');
    }

    /**
     * @inheritdoc
     * @return TrenerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrenerQuery(get_called_class());
    }
}
