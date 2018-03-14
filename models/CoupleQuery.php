<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Couple]].
 *
 * @see Couple
 */
class CoupleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Couple[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Couple|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
