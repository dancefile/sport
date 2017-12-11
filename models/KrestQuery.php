<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Krest]].
 *
 * @see Krest
 */
class KrestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Krest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Krest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
