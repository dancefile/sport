<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clas".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Dancer[] $dancers
 * @property Dancer[] $dancers0
 */
class Clas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancers()
    {
        return $this->hasMany(Dancer::className(), ['clas_id_st' => 'id'])->inverseOf('clasIdSt');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDancers0()
    {
        return $this->hasMany(Dancer::className(), ['clas_id_la' => 'id'])->inverseOf('clasIdLa');
    }

    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['clas_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ClasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasQuery(get_called_class());
    }
}
