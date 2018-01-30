<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pre_registration".
 *
 * @property int $id
 * @property string $category
 * @property string $class
 * @property string $dancer1_name
 * @property string $dancer1_sname
 * @property string $dancer2_name
 * @property string $dancer2_sname
 * @property string $city
 * @property string $club
 * @property string $trener
 */
class PreRegistration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_registration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'dancer1_name', 'dancer1_sname', 'dancer2_name', 'dancer2_sname', 'city', 'club', 'trener'], 'string', 'max' => 200],
            [['class'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'class' => 'Class',
            'dancer1_name' => 'Dancer1 Name',
            'dancer1_sname' => 'Dancer1 Sname',
            'dancer2_name' => 'Dancer2 Name',
            'dancer2_sname' => 'Dancer2 Sname',
            'city' => 'City',
            'club' => 'Club',
            'trener' => 'Trener',
        ];
    }
}
