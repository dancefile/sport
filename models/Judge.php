<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "judge".
 *
 * @property integer $id
 * @property string $name
 * @property string $sname
 * @property integer $language_id
 *
 * @property Chess[] $chesses
 * @property Language $language
 * @property Krest[] $krests
 */
class Judge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'judge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['name'], 'required'],
            [['language_id'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['sname'], 'string', 'max' => 250],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'sname' => 'Фамилия',
            'language_id' => 'Язык',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChesses()
    {
        return $this->hasMany(Chess::className(), ['judge_id' => 'id'])->inverseOf('judge');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id'])->inverseOf('judges');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKrests()
    {
        return $this->hasMany(Krest::className(), ['judge_id' => 'id'])->inverseOf('judge');
    }

    /**
     * @inheritdoc
     * @return JudgeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JudgeQuery(get_called_class());
    }
}
