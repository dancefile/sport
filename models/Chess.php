<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chess".
 *
 * @property integer $id
 * @property integer $judge_id
 * @property integer $category_id
 * @property string $nomer
 *
 * @property Judge $judge
 * @property Category $category
 */
class Chess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['judge_id', 'category_id'], 'required'],
            [['judge_id', 'category_id', 'nomer'], 'integer'],
            [['judge_id'], 'exist', 'skipOnError' => true, 'targetClass' => Judge::className(), 'targetAttribute' => ['judge_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'nomer' => 'Nomer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJudge()
    {
        return $this->hasOne(Judge::className(), ['id' => 'judge_id'])->inverseOf('chesses');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->inverseOf('chesses');
    }

    /**
     * @inheritdoc
     * @return ChessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChessQuery(get_called_class());
    }
}
