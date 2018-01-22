<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Tur]].
 *
 * @see Tur
 */
class TurQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Tur[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tur|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    
}
