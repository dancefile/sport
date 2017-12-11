<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Setings]].
 *
 * @see Setings
 */
class SetingsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Setings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Setings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
