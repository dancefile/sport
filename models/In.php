<?php

namespace app\models;

use Yii;
use app\models\Clas;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "in".
 *
 * @property integer $id
 * @property integer $couple_id
 * @property integer $tur_id
 *
 * @property Couple $couple
 * @property Tur $tur
 * @property InDance $inDance
 */
class In extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in';
    }


    public $dancer1=['name'=>'', 'sname'=>'', 'date'=>'', 'clas_id_st'=>'', 'clas_id_la'=>'', 'booknumber'=>''];
    public $dancer2=['name'=>'', 'sname'=>'', 'date'=>'', 'clas_id_st'=>'', 'clas_id_la'=>'', 'booknumber'=>''];
    public $common=['club'=>'', 'city'=>'', 'country'=>'', 'dancer_trener'=>[]];
    // public $reg_list=['tur_id'=>'', 'number'=>'', 'dancer_id_1'=>'', 'dancer_id_2'=>''];




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['couple_id', 'tur_id'], 'required'],
            [['couple_id', 'tur_id'], 'integer'],
            [['couple_id'], 'exist', 'skipOnError' => true, 'targetClass' => Couple::className(), 'targetAttribute' => ['couple_id' => 'id']],
            [['tur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tur::className(), 'targetAttribute' => ['tur_id' => 'id']],
            [['dancer1', 'dancer2', 'common'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'couple_id' => 'Couple ID',
            'tur_id' => 'Tur ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouple()
    {
        return $this->hasOne(Couple::className(), ['id' => 'couple_id'])->inverseOf('ins');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTur()
    {
        return $this->hasOne(Tur::className(), ['id' => 'tur_id'])->inverseOf('ins');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInDance()
    {
        return $this->hasOne(InDance::className(), ['id' => 'id'])->inverseOf('id0');
    }

    public function getClassList()
    {
        return ArrayHelper::map(Clas::find()->all(), 'id', 'name');
    }

    public function getCategoryList()
    {
        $a = Tur::find()->select(['id', 'nomer'])->all();
// ArrayHelper::map($a, 'turs.id', 'name')
        return $a;
    }

    /**
     * @inheritdoc
     * @return InQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InQuery(get_called_class());
    }
}
