<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setings".
 *
 * @property integer $id
 * @property string $comp_name
 * @property string $value
 * @property string $comp_date
 * @property string $comp_org
 */
class Setings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comp_name', 'value'], 'required'],
            [['comp_name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 250],
            [['comp_date', 'comp_org'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comp_name' => 'Comp Name',
            'value' => 'Value',
            'comp_date' => 'Comp Date',
            'comp_org' => 'Comp Org',
        ];
    }

    /**
     * @inheritdoc
     * @return SetingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetingsQuery(get_called_class());
    }
}
