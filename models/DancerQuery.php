<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Dancer]].
 *
 * @see Dancer
 */
class DancerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Dancer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Dancer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
