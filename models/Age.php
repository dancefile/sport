<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "age".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Category[] $categories
 */
class Age extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'age';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 250],
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
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['age_id' => 'id'])->inverseOf('age');
    }

    /**
     * @inheritdoc
     * @return AgeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgeQuery(get_called_class());
    }
}
