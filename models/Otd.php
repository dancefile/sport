<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "otd".
 *
 * @property integer $id
 * @property integer $name
 *
 * @property Category $id0
 */
class Otd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'otd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'id'], 'integer'],
//            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id' => 'otd_id']],
            [['startTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'startTime' => 'Старт',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['otd_id' => 'id'])->inverseOf('otd');
    }


}
